<?php

/**
 * @class blog  Handles blog data
 */
class blog extends CI_Model
{

    /**
     * @method  void    __construct
     */
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * @method  mixed       getPostByID     Requests a blog post by ID number
     * @param   int|null    $id             The ID of the blog post
     * @param   bool        $img_metadata   Whether or not to show extended image metadata (upload and modification info)
     * @returns array|bool|null             The blog post, false (no record found) or null (invalid ID)
     */
    function getPostByID($id = null, $img_metadata = false)
    {
        // If null post ID, return null back
        // @todo Refactor into throwing exception
        if (empty($id)) return null;

        // Pass to generic getPost function
        return $this->getPost('bp.id', $id, $img_metadata);
    }

    /**
     * @method  mixed       getPostBySlug   Requests a blog post by URI segment/slug
     * @param   int|null    $slug           The slug of the blog post
     * @param   bool        $img_metadata   Whether or not to show extended image metadata (upload and modification info)
     * @returns array|bool|null             The blog post, false (no record found) or null (invalid slug)
     */
    function getPostBySlug($slug = null, $img_metadata = false)
    {
        // If null post slug, return null back
        // @todo Refactor into throwing exception
        if (empty($slug)) return null;

        // Pass to generic getPost function
        return $this->getPost('bp.slug', $slug, $img_metadata);
    }

    /**
     * @method  mixed       getPost         Requests a blog post based on field/value data
     * @param   string|null $field          The field to filter by
     * @param   int|null    $value          The value to filter on
     * @param   bool        $img_metadata   Whether or not to show extended image metadata (upload and modification info)
     * @returns array|bool|null             The blog post, false (no record found) or null (invalid ID)
     */
    function getPost($field = null, $value = null, $img_metadata = false)
    {
        // Build query
        $this->db->select('bp.*');
        $this->db->select('CONCAT(`mp`.`first_name`, " ", `mp`.`last_name`) AS `poster_name`', false);
        $this->db->select('CONCAT(`mlm`.`first_name`, " ", `mlm`.`last_name`) AS `last_modified_name`', false);
        $this->db->select('img.orig_name AS image_orig_name');
        $this->db->select('img.app AS image_app');
        $this->db->select('img.ext AS image_ext');
        if ($img_metadata === true)
        {
            $this->db->select('img.date_uploaded AS image_date_uploaded');
            $this->db->select('img.uploaded_by AS image_uploaded_by');
            $this->db->select('img.date_last_modified AS image_date_last_modified');
            $this->db->select('img.last_modified_by AS image_last_modified_by');
            $this->db->select('CONCAT(`miu`.`first_name`, " ", `miu`.`last_name`) AS `image_uploader_name`', false);
            $this->db->select('CONCAT(`milm`.`first_name`, " ", `milm`.`last_name`) AS `image_last_modified_name`', false);
        }
        $this->db->from('blog_posts AS bp');
        $this->db->join('members AS mp', 'bp.posted_by = mp.id', 'left');
        $this->db->join('members AS mlm', 'bp.last_modified_by = mlm.id', 'left');
        $this->db->join('image_uploads AS img', 'bp.image_id = img.id', 'left');
        if ($img_metadata === true)
        {
            $this->db->join('members AS miu', 'img.uploaded_by = miu.id', 'left');
            $this->db->join('members AS milm', 'img.last_modified_by = milm.id', 'left');
        }
        $this->db->where($field, $value);
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();

        // If not found, return false
        if (!$results || $results->num_rows() == 0) return false;

        // Store record locally
        $post = $results->row_array();

        // Get additional information
        $post['tags']    = $this->getPostTags($post['id']);
        unflattenImageInfo($post);

        // Return back formatted row
        return $post;
    }

    /**
     * @method  mixed   getAllPostTags  Get all tags, along with count, sorted by name
     * @returns array|bool|null         The list of tags or false (no tags found)
     */
    function getAllPostTags()
    {
        // Build query
        $this->db->select('bt.*');
        $this->db->select('COUNT(`bpt`.`tag_id`) AS `amount`', false);
        $this->db->from('blog_post_tags AS bpt');
        $this->db->join('blog_tags AS bt', 'bpt.tag_id = bt.id', 'left');
        $this->db->order_by('name');

        // Get results
        $results = $this->db->get();

        // Return post tags, if any
        return $results->result_array() ?: false;
    }

    /**
     * @method  mixed   getPostTags Get all tags for a given post
     * @param   int     $id         The ID of the blog post
     * @returns array|bool|null     The list of tags, false (no record found), or null (invalid ID)
     */
    function getPostTags($id)
    {
        // If null post ID, return null back
        // @todo Refactor into throwing exception
        if (empty($id)) return null;

        // Build query
        $this->db->select('bt.*');
        $this->db->from('blog_post_tags AS bpt');
        $this->db->join('blog_tags AS bt', 'bpt.tag_id = bt.id', 'left');
        $this->db->where('post_id', $id);
        $this->db->order_by('name');

        // Get results
        $results = $this->db->get();

        // Return post tags, if any
        return $results->result_array() ?: false;
    }

    /**
     * @method  mixed       getVisibilities Get a list of all possible visibility values from DB
     * @returns array|bool                  The list of visibilities
     */
    function getVisibilities()
    {
        // Build query
        $this->db->select('*');
        $this->db->from('blog_post_visibilities');
        $this->db->order_by('sort_order');

        // Get results
        $results = $this->db->get();

        // Return results
        return $results->result_array() ?: false;
    }

    /**
     * @method  mixed       getStatuses Get a list of all possible status values from DB
     * @returns array|bool              The list of statuses
     */
    function getStatuses()
    {
        // Build query
        $this->db->select('*');
        $this->db->from('blog_post_statuses');
        $this->db->order_by('sort_order');

        // Get results
        $results = $this->db->get();

        // Return results
        return $results->result_array() ?: false;
    }

    /**
     * @method  bool    slugExists  Returns whether or not a blog slug (permalink) exists in DB
     * @param   string  $slug       The slug to check
     * @returns bool                Whether or not the slug exists
     */
    function slugExists($slug)
    {
        // Build query
        $this->db->select('id');
        $this->db->from('blog_posts');
        $this->db->where('slug', $slug);
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();

        // Return whether a row was found or not
        return ($results->num_rows() == 1);
    }

    /**
     * @method  bool    uploadBlogImage Uploads an image record to the DB
     * @param   array   $data           The image data
     * @returns bool                    Whether the DB insert succeeded
     */
    function uploadBlogImage($data)
    {
        // Get ID of updater
        $updater_id = (!empty($this->session->userdata('member_id')) ? $this->session->userdata('member_id') : SYSTEM_MEMBER_ID);

        // Add recordkeeping
        $data['uploaded_by']        = $updater_id;
        $data['last_modified_by']   = $updater_id;

        // Insert record into database and return success
        return $this->db->insert('image_uploads', $data);
    }
}
