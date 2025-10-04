    <div class="footer">
      <div class="footerlinkarea">
        <div class="footerlinkmain">COMPANY</div>
        <div class="footerlink">
          <ul>
            <li><a href="<?php echo SITE_URL; ?>inside-xantatech/why-xantatech.php" rel="nofollow">Why us</a></li>
            <li><a href="<?php echo SITE_URL; ?>website-design.php">Services</a></li>
            <li><a href="<?php echo SITE_URL; ?>plan.php" rel="nofollow">Packages</a></li>
            <li><a href="<?php echo SITE_URL; ?>inside-xantatech/privacy-policy.php" rel="nofollow">Our Policy</a></li>
            <li><a href="<?php echo SITE_URL; ?>term-condition.php" rel="nofollow">Terms &amp; Conditions</a></li>
            <li><a href="<?php echo SITE_URL; ?>contact.html" rel="nofollow">Contact Us</a></li>
          </ul>
        </div>
      </div>

      <div class="footerlinkarea">
        <div class="footerlinkmain">RESOURCES</div>
        <div class="footerlink">
          <ul>
            <li><a href="<?php echo SITE_URL; ?>inside-xantatech/press-release.php" rel="nofollow">Press Release</a></li>
            <li><a href="<?php echo SITE_URL; ?>articles.php" rel="nofollow">Article</a></li>
            <li><a href="<?php echo SITE_URL; ?>blog/" target="_blank" rel="nofollow">Blog</a></li>
            <li><a href="<?php echo SITE_URL; ?>inside-xantatech/client-testomonials.php" rel="nofollow">Testimonials</a></li>
          </ul>
        </div>
      </div>
      <div class="footerlinkarea">
        <div class="footerlinkmain">Support</div>
        <div class="footerlink">
          <ul>
            <li><a href="<?php echo SITE_URL; ?>customers-support.php" rel="nofollow">Consumer Support</a></li>
            <li><a href="<?php echo SITE_URL; ?>inside-xantatech/refund-cancellation-policy.php" rel="nofollow">Refund Policy</a></li>
            <li><a href="<?php echo SITE_URL; ?>payment-process.php" rel="nofollow">Payment process</a></li>
            <li><a href="<?php echo SITE_URL; ?>custompayment.php" rel="nofollow">Custom Payment</a></li>
          </ul>
        </div>
      </div>
      <div class="footerlinkarea-address">
        <div class="footerlink_address">
          <div class="footer-addtext-new">
            <div class="testimonials">Testimonials</div>
            <div class="testimonials-inner">
            <?php

            $sq=mysql_query("select name,content,country from tbl_testimonials where show_on_home ='1' order by testimonial_id desc");
            $data=mysql_fetch_array($sq);
            ?>
              <p><?php echo substr($data['content'],20); ?>... <span><?php echo $data['name']; ?> (<?php echo $data['country']; ?>)</span> </p>
            </div>
            <div class="read"><a href="testimonial.html">View More</a></div>
          </div>
        </div>
        <a href="#top" class="top"><img src="<?php echo SITE_URL; ?>images/top.png" alt="Back to Top" title="Back to Top"/></a> </div>
    </div>
    <div class="bottomcompyright">
      <div class="compyright"> Copyright &copy; Xantatech Pvt. Ltd, All Rights Reserved 
      <span>
      <?php
          $tofetch=array('addressline1','addressline2');
          $result=get_single_record('tbl_setting_borderlinx',1,$tofetch,'id');

      ?>
      <?php echo  $result->addressline1;?>&nbsp;&nbsp; <?php echo  $result->addressline2;?></span>
      </div>
    </div>
 