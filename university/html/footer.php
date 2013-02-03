<?php
// Display admin menu when on admin pages and logged in
if (!$printable && isset($_SESSION['s_username']) && substr($_SERVER['PHP_SELF'], 0, strlen($ADMIN_DIR)) == $ADMIN_DIR)
{
?>
      </td>
   </tr>
</table>
<?php
}
?>
      <br/>
      </td>
   </tr>
   <tr><td colspan="4" bgcolor="<?php echo $accent_color;?>"><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="1" alt="W3C Compliant Table Data" border="0"/></td></tr>
   <tr>
      <td colspan="4" align="center">
      <br/>
<?php
if (!$printable)
{
   $printer_url = $_SERVER['PHP_SELF'] . "?printable=1";
   if (isset($_SERVER['QUERY_STRING']))
   {
      $printer_url .= "&amp;" . $_SERVER['QUERY_STRING'];
   }
?>
      <a class="menu" href="#skip_navigation">Return to Top</a>&nbsp;&nbsp;&nbsp;<a class="menu" href="<?php echo $printer_url; ?>">Printer-Friendly Version</a>
      <br/><br/>
<?php
}

if (!$printable)
{
?>
      <p class="copy">
      The data on this web site is maintained by the University Chancellor, 
      <a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=university&amp;d=atlantia.sca.org" target="redir">Mistress Genevieve d'Aquitaine</a>, and the University Registrar, 
      <a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=registrar&amp;d=atlantia.sca.org" target="redir">Mistress Thjora Arnketilsdóttir</a>.  
      <br/><br/>
      This is the recognized website for the University of the <a href="http://atlantia.sca.org">Kingdom of Atlantia</a> of the <a href="http://www.sca.org">Society for Creative Anachronism</a>, Inc. 
      and is maintained by <a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=webminister&amp;d=atlantia.sca.org" target="redir">Maestra Cassandra Arabella Giordani (Kim Jordan)</a>. 
      This site may contain electronic versions of the branch's governing documents. 
      Any discrepancies between the electronic version of any information on this site and the printed version that is available from the originating office will be decided in favor of the printed version.
      <br/><br/>
      Copyright &copy; 2009-<?php echo date("Y"); ?> University of Atlantia.  The original contributors retain the copyright of certain portions of this site.
      <br/><br/>
      For information on using photographs, articles, or artwork from this website, please contact the web minister at 
      <a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=webminister&amp;d=atlantia.sca.org" target="redir">webminister AT atlantia.sca.org</a>. 
      They will assist you in contacting the original creator of the piece.  Please respect the legal rights of our contributors.
      <br/><br/>
      All external links are not part of the University of Atlantia website. 
      Inclusion of a page or site here is neither implicit nor explicit endorsement of the site. 
      Further, <acronym title="Society for Creative Anachronism">SCA</acronym>, Inc. is not responsible for content outside of university.atlantia.sca.org.
      <br/><br/>
      University badge rendered by Corun MacAnndra.
      </p>
      <table align="center" border="0" summary="table for layout and formatting">
         <tr>
            <td><a href="http://validator.w3.org/check?uri=referer" title="External Link"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0"/></a></td>
            <td><a href="http://jigsaw.w3.org/css-validator/validator?uri=http://university.atlantia.sca.org/university.css" title="External Link"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS"/></a></td>
         </tr>
      </table>
<?php
}
?>
      <br/>
      </td>
   </tr>
</table>
<iframe name="redir" width="1" height="1" frameborder="0" scrolling="no" style="visibility:hidden;"></iframe>
</body>
</html>
