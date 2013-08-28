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
   $is_search = false;
   if (strstr($_SERVER['PHP_SELF'], "search.php"))
   {
      $is_search = true;
   }

   $printer_url = $_SERVER['PHP_SELF'] . "?printable=1";
   if (isset($_SERVER['QUERY_STRING']))
   {
      $printer_url .= "&amp;" . $_SERVER['QUERY_STRING'];
   }
?>
      <a class="menu" href="#opmenu">Return to Top</a><?php if (!$is_search) { ?>&nbsp;&nbsp;&nbsp;<a class="menu" href="<?php echo $printer_url; ?>">Printer-Friendly Version</a><?php } ?>
      <br/><br/>
      <table align="center" border="0" summary="table for layout and formatting">
         <tr>
            <td><a href="http://validator.w3.org/check?uri=referer" title="External Link"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0"/></a></td>
            <td><a href="http://jigsaw.w3.org/css-validator/validator?uri=http://op.atlantia.sca.org/op.css" title="External Link"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS"/></a></td>
         </tr>
      </table>
<?php
}

if (!$printable)
{
?>
      <p class="copy">
      The data on this web site is maintained by the Clerk of Precedence, <a href="functions/mailto.php?u=shepherds.crook&amp;d=eastkingdom.org" target="redir">Duchess Anna Halloway</a>.  Please use the <a href="corrections.php">corrections form</a> to report any issues with OP data.
      <br/><br/>
      This is the recognized website for the Order of Precedence of the <a href="http://easkingdom.org">Kingdom of the <?php echo $KINGDOM_NAME; ?></a> of the <a href="http://www.sca.org">Society for Creative Anachronism</a>, Inc. 
       
      This site may contain electronic versions of the branch's governing documents. 
      Any discrepancies between the electronic version of any information on this site and the printed version that is available from the originating office will be decided in favor of the printed version.
      <br/><br/>
      Copyright &copy; 2005-<?php echo date("Y"); ?> Order of Precedence of the Kingdom of the<?php echo $KINGDOM_NAME; ?>.  The original contributors retain the copyright of certain portions of this site.
      <br/><br/>
      
      All external links are not part of the Order of Precedence website. 
      Inclusion of a page or site here is neither implicit nor explicit endorsement of the site. 
      Further, <acronym title="Society for Creative Anachronism">SCA</acronym>, Inc. is not responsible for content outside of op.atlantia.sca.org.
      <br/><br/>
    
      </p>
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
