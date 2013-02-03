<?php
$title = "Teach";
include("header.php");

/* Connecting, selecting database */
$link = db_connect();

// Retrieve current university session if no session is specified
$query = "SELECT university.*, branch.*, branch_type.branch_type " .
         "FROM $DBNAME_UNIVERSITY.university JOIN $DBNAME_BRANCH.branch ON university.branch_id = branch.branch_id " .
         "JOIN $DBNAME_BRANCH.branch_type ON branch.branch_type_id = branch_type.branch_type_id " .
         "WHERE university.is_university = 1 " .
         "AND university.university_date = (SELECT MAX(university_date) FROM $DBNAME_UNIVERSITY.university WHERE is_university = 1)";
$result = mysql_query($query)
   or die("Current University Query failed : " . mysql_error());
$data = mysql_fetch_array($result, MYSQL_BOTH);

$university_code = clean($data['university_code']);
$university_number = substr($university_code, 2);
$university_date = clean($data['university_date']);
$track_proposal_date = clean($data['track_proposal_date']);
$individual_proposal_date = clean($data['individual_proposal_date']);

$branch_name = clean($data['branch']);
$branch_type = clean($data['branch_type']);
$incipient = clean($data['incipient']);
$incpient_display = "";
if ($incipient == 1)
{
   $incpient_display = "Incipient ";
}

$location_display = $incpient_display . $branch_type . " of " . $branch_name;
$date_display = format_full_date($university_date);

mysql_free_result($result);
db_disconnect($link);
?>
<p class="datacenter">Thank you for your interest in teaching at an upcoming University session.</p>
<p class="datacenter">Currently accepting class proposals for:<br/>
<b>Session #<?php echo $university_number; ?>, <?php echo $location_display; ?><br/>
<?php echo $date_display; ?></b>
</p>
<p class="datacenter">
Deadline for TRACK proposals is <b><?php echo format_full_date($track_proposal_date); ?></b>.<br/>
Deadline for INDIVIDUAL CLASS proposals is <b><?php echo format_full_date($individual_proposal_date); ?></b>.
</p>
<p class="datacenter">Please read the following before submitting class or track proposals.</p>
<h2 style="text-align:center">Teaching at University</h2>
<table width="95%" border="0" cellspacing="2" cellpadding="5">
   <tr>
      <td valign="top">
      <h3>General Information:</h3>
      <ul>
         <li>University classes are 50 minutes at 10:00, 11:00, 1:30, 2:30, 3:30, &amp; 4:30.</li>
         <li>Some classes may be two or more slots.</li>
         <li>Usually an individual may teach no more than two classes at each session.</li>
         <li>Class proposals may be sent to the University Chancellor via <a href="functions/mailto.php?u=university&amp;d=atlantia.sca.org" target="redir">email</a>, 
         or <a href="chancellor.php">USPS</a><!-- , or by completing the <a href="proposal.php">Online Class Proposal Form</a>-->.</li>
         <!--<li>View instructions (<a href="online.php">Online Reference Submission Form</a>) to submit an electronic copy of your class material to the University of Atlantia for distribution.</li>-->
         <li>A track is a series of classes on a particular topic that is usually scheduled sequentially in the same room. Complete tracks are sent as one message.</li>
         <li>Follow up a face to face discussion with the chancellor with an email or written communication.</li>
         <li>If you are proposing more than one class, please rank them by preference.</li>
      </ul>
      <h3>Proposal Format:</h3>
      <ul>
         <li>Title of the Class (SCA name(s) of teacher(s) without titles). Brief description of the class. Include URL, phone number or email for more information about class, if you like. Any equipment students need to bring. Class length. Enrollment limit, if any. Materials fee, if any.</li>
         <li>Include modern name and contact information (email or phone). Please include legal name and contact information for all teachers in track proposals.</li>
         <li>Please use plain text without fancy formatting to simplify catalog preparation.</li>
         <li>The Acorn catalog will have only the title, teachers' SCA names, and codes for length, limits, equipment needed, and fees. Full descriptions will be on the <a href="catalog.php">web site</a>.</li>
         <li>Include any special room requirements for space, tables, or A/V equipment. Please indicate which rapier and heavy classes will actually swing weapons, so that MoL and marshals may be arranged. Indicate if the teacher can provide marshal supervision.</li>
      </ul>
      </td>
      <td valign="top">
      <h3>Deadlines:</h3>
      <ul>
         <li>Individual proposals and final tracks are due 2 &frac12; months before the session: 11/15 for February, 3/15 for June, and 7/10 for October.</li>
         <li>Three months prior to each session, track proposals are due. This is merely to reserve the track space. Final tracks with the data for all classes are due 2 &frac12; months prior to the session. There will be a limited number of tracks guaranteed at the three months deadline. Other tracks may be proposed and ultimately scheduled as the rest of the individual proposals are received and space is available.</li>
         <li>Proposals received after the deadline may be scheduled if space is available or cancellations are received.</li>
      </ul>
      <h3>Criteria for selecting classes:</h3>
      <ul>
         <li>When a class proposal is received</li>
         <li>Kingdom officers' classes have priority</li>
         <li>How recently the class has been taught</li>
         <li>Novelty/spiffness/coolness of class</li>
         <li>Is this a popular, limited enrollment class that always fills up?</li>
         <li>Chancellor's whim</li>
      </ul>
      <h3>At University:</h3>
      <ul>
         <li>Pick up your class roster from the Registrar.</li>
         <li>Have all students check off their name if they pre-registered.</li>
         <li>Students not pre-registered fill in legal and SCA names legibly on the roster.</li>
         <li>Return the roster to the Registrar before you leave the site so that all students may receive credit for classes taken.</li>
      </ul>
      </td>
   </tr>
</table>
<p class="datacenter"><b>For rapier and heavy classes that will actually swing weapons</b>, there must be a warranted MoL to check authorizations and warranted marshals for safety. Please make this need clear in the class proposal. If the instructor is a marshal or has arranged for a marshal, please mention this.</p>

<?php include("footer.php"); ?>