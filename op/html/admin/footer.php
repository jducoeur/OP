      <br/>
      </td>
   </tr>
   <tr><td colspan="4" bgcolor="<?php echo $accent_color;?>" height="1"><img src="<?php echo $IMAGES_DIR; ?>spacer.gif" width="0" height="0" alt="W3C Compliant Table Data" border="0"/></td></tr>
   <tr>
      <td colspan="4" align="center">
      <br/>
<?php
if (!$printable)
{
   $is_printable = false;
   if (strstr($_SERVER['PHP_SELF'], "kingdom_op.php") || strstr($_SERVER['PHP_SELF'], "unknown.php") || strstr($_SERVER['PHP_SELF'], "private.php") || strstr($_SERVER['PHP_SELF'], "branch.php") || 
       strstr($_SERVER['PHP_SELF'], "overdue.php") || strstr($_SERVER['PHP_SELF'], "baronage.php") || strstr($_SERVER['PHP_SELF'], "monarchs.php") || strstr($_SERVER['PHP_SELF'], "principality.php"))
   {
      $is_printable = true;
   }

   $printer_url = $_SERVER['PHP_SELF'] . "?printable=1";
   if (isset($_SERVER['QUERY_STRING']))
   {
      $printer_url .= "&amp;" . $_SERVER['QUERY_STRING'];
   }
?>
      <a class="menu" href="#opmenu">Return to Top</a><?php if ($is_printable) { ?>&nbsp;&nbsp;&nbsp;<a class="menu" href="<?php echo $printer_url; ?>">Printer-Friendly Version</a><?php } ?>
      <br/><br/>
      <table align="center" border="0" summary="table for layout and formatting">
         <tr>
            <td><a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0"/></a></td>
            <td><a href="http://jigsaw.w3.org/css-validator/validator?uri=http://op.atlantia.sca.org/op.css"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS"/></a></td>
         </tr>
      </table>
<?php
}
?>
      <p class="copy">
      Copyright &copy; 2005-<?php echo date('Y'); ?>, Kingdom of Atlantia/SCA, Inc.
<?php
if (!$printable)
{
?>
      <br/><br/>
      Web Site created and maintained by Maestra Cassandra Arabella Giordani (<a href="<?php echo $HOME_DIR; ?>functions/mailto.php?u=webminister&amp;d=atlantia.sca.org" target="redir">webminister AT atlantia.sca.org</a>)
<?php
}
?>
      </p>
      <br/>
      </td>
   </tr>
</table>
<iframe name="redir" width="1" height="1" frameborder="0" scrolling="no" style="visibility:hidden;"></iframe>
</body>
</html>
