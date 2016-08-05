<h1>Club News &amp; Signature Events</h1>
<div id="events_container">
    <aside id="upcoming_events">
        <h2>Upcoming Events</h2>
<?  if (empty($upcoming_events)): ?>
        <p class="upcoming_event_message">There are no upcoming events at this time. Please check back soon -- we're adding events all the time!</p>
<?  else: ?>
        <div id="upcoming_event_days">
<?      foreach ($upcoming_events as $day => $events): ?>
            <div class="upcoming_event_day">
                <div class="cal-icon-container small">
                    <div class="cal-icon">
                        <div class="cal-icon-banner">
                            <div class="cal-icon-month"><?=date('M', strtotime($day)) ?></div>
                            <div class="cal-icon-dow"><?=date('D', strtotime($day)) ?></div>
                        </div>
                        <div class="cal-icon-body">
                            <div class="cal-icon-day"><?=date('j', strtotime($day)) ?></div>
                        </div>
                    </div>
                </div>
                <div class="upcoming_event_list clearfix">
<?          foreach ($events as $event): ?>
                    <div class="upcoming_event">
                        <a href="/event/<?=$event['_data']['full_slug'] ?>" class="eventlink"></a>
                        <h3><?=$event['name'] ?></h3>
                        <div class="upcoming_event_time"><i class="fa fa-clock-o"></i> <?=$event['date_start']['time_text'] ?></div>
                        <div class="upcoming_event_location"><i class="fa fa-map-marker"></i> <?=$event['location'] ?></div>
                    </div>
<?          endforeach; ?>
                </div>
            </div>
            <div class="clearfix"></div>
<?      endforeach; ?>
        </div>
<?  endif; ?>
        <div id="cal-view-button"><a href="/calendar/"><i class="fa fa-calendar"></i> View Events Calendar</a></div>
    </aside>
    <h2>Recurring Events</h2>
    <h3>Children's Book Bank</h3>
    <p>The Children's Book Bank strives to improve the literacy skills of low-income children by giving them books of their own. To do this, The Children's Book Bank collects, repairs, and packages community-donated used books. The books are then made available to Portland families- free of charge.</p>
    <h3>Oregon Food Bank</h3>
    <p>Oregon Food Bank is a nonprofit, charitable organization that works holistically to help low-income families alleviate hunger and its root causes. OFB helps nearly one in five households fend off hunger by distributing food from a variety of sources through a statewide network that includes its four branches (in Beaverton, Ontario, Portland and Tillamook), 16 independent regional food banks and 947 partner agencies. Oregon Food Bank also addresses the root causes of hunger through advocacy, education programs for low-income youth and adults and by bringing communities together to strengthen local and regional food systems. Active 20/30 members will spend time sorting and organizing food for local families.</p>
    <h3>Habitat for Humanity</h3>
    <p>Habitat for Humanity is a non-profit Christian housing ministry that builds and repairs houses all over the world using volunteer labor and donations.  Homeowners invest hundreds of hours of their own labor into building their Habitat house and the houses of others.  Partner families purchase these houses through no-profit mortgage loans or innovative financing methods. Members will spend their time assisting with the building process.</p>
    <p>Habitat for Humanity ReStores are nonprofit home improvement stores and donation centers that sell new and gently used furniture, home accessories, building materials, and appliances to the public at a fraction of the retail price.  Habitat for Humanity ReStores are proudly owned and operated by local Habitat for Humanity affiliates, and proceeds are used to build homes, community, and hope locally and around the world.</p>
    <h3>Ronald McDonald House</h3>
    <p>Located on the grounds of Randal Children's Hospital, the Ronald McDonald House provides a "home away from home" for families with seriously ill children. The Ronald McDonald House has multiple needs including, cleaning rooms for incoming families, landscaping, and preparing cookies and other treats for residents.</p>
    <h3>Northwest Children's Outreach</h3>
    <p>This is a faith-based, non-profit organization dedicated to helping families in the Portland area and surrounding communities. They help fill the needs of these families, providing clothing, infant care products, diapers, formula and many of the other necessities parents need for their children. Active 20/30 members will be helping to sort and pack boxes of materials that parents need to care for their children.</p>
    <h2>Signature Events</h2>
    <h3>Back to School Celebration at Bridge Meadows</h3>
    <p>Bridge Meadows is an innovative community designed to bring together three generations to support families adopting children from foster care. Former foster youth move from instability to finding permanency, supported by adoptive parents and elders who, all together, form intentional families and connections that are greater than the sum of their parts. Permanence is a significant factor in improving social, educational and economic outcomes for foster youth. Bridge Meadows' offers former foster youth permanent families with their brothers and sister, and a true home where kids and parents can heal, learn and thrive together. This event focuses on the importance of education and staying in school while providing new backpacks full of school supplies and a new pair of shoes to each child to ensure they start the school year off right.</p>
    <h3>Garage Sale Fundraiser</h3>
    <p>Held annually each June, this two-day garage sale helps the club raise critical funds for the back to school celebration at Bridge Meadows.  Our first year raised more than $600 for backpacks, school supplies, and new shoes for children in need.  Activans need assistance with the set-up, clean-up and or course the donation of items!</p>
    <h3>Flocking</h3>
    <p>This signature event is a fun way to increase awareness of the Active 20/30 Club of Portland by "flocking" a friend, family, or neighbor's yard with flamingos. This crazy fundraiser allows us to raise money for our annual back to school celebration at Bridge Meadows.  A friendly ransom or donation is appreciated in exchange for the flock removal.</p>
    <h2>National &amp; International Events</h2>
    <div class="upcoming_event_day">
        <div class="cal-icon-container small">
            <div class="cal-icon">
                <div class="cal-icon-banner">
                    <div class="cal-icon-month">Jun</div>
                    <div class="cal-icon-dow">Th</div>
                </div>
                <div class="cal-icon-body">
                    <div class="cal-icon-day">4</div>
                </div>
            </div>
        </div>
        <div class="upcoming_event_list">
            <div class="upcoming_event">
                <a href="http://www.active20-30.org/national-convention" rel="nofollow" class="eventlink"></a>
                <h3>2015 Active 20-30 National Convention</h3>
                <div class="upcoming_event_dates"><i class="fa fa-calendar"></i> June 4 - 6</div>
                <div class="upcoming_event_location"><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="upcoming_event_day">
        <div class="cal-icon-container small">
            <div class="cal-icon">
                <div class="cal-icon-banner">
                    <div class="cal-icon-month">Jul</div>
                    <div class="cal-icon-dow">W</div>
                </div>
                <div class="cal-icon-body">
                    <div class="cal-icon-day">15</div>
                </div>
            </div>
        </div>
        <div class="upcoming_event_list">
            <div class="upcoming_event">
                <a href="http://www.active20-30.org/international-events" rel="nofollow" class="eventlink"></a>
                <h3>2015 Active 20-30 International Convention</h3>
                <div class="upcoming_event_dates"><i class="fa fa-calendar"></i> July 15 - 19</div>
                <div class="upcoming_event_location"><i class="fa fa-map-marker"></i> San Salvador, El Salvador</div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!--<h3>Active 20-30 Midterm</h3>
    <p>November 21-23, 2014 &ndash; Scottsdale, Arizona, USA &ndash; <a href="http://www.active20-30.org/national-midterm" rel="nofollow" target="_blank">Details</a></p>-->
</div>