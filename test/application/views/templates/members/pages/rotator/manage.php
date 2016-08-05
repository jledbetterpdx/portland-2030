<h1><i class="fa fa-photo"></i><?=$page['title'] ?></h1>
<?  if (!empty($this->session->flashdata('message'))): ?>
    <div id="message" class="<?=$this->session->flashdata('class') ?>"><?=$this->session->flashdata('message') ?></div>
<?  endif; ?>
<div id="tab-container" class="tab-container">
    <ul class="etabs">
        <li class="tab"><a href="#active"><i class="fa fa-play fa-fw"></i>Active</a></li>
        <li class="tab"><a href="#archived"><i class="fa fa-archive fa-fw"></i>Archived</a></li>
        <li class="tab"><a href="#settings"><i class="fa fa-cogs fa-fw"></i>Rotator Settings</a></li>
    </ul>
