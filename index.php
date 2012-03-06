<?php
session_start();
require_once 'tmhOAuth/FixTheWeb.php';

// Configure Twitter OAuth with the right credentials

$tmhOAuth_config = array(
  'consumer_key'    => 'YOUR_CONSUMER_KEY',
  'consumer_secret' => 'YOUR_CONSUMER_SECRET',
);

$FixTheWeb = new FixTheWeb(new tmhOAuth($tmhOAuth_config));
$logged_in = $FixTheWeb->isAuthed();

if ($logged_in) 
    $twitter_name = $FixTheWeb->userdata->screen_name;
if (isset($_GET['login'])) {
    $FixTheWeb->auth();
}

// logout user when s/he clicks the logout link 

if ($logged_in) {    
    if (isset($_GET['logout'])) {
        $FixTheWeb->endSession();
        header ('Location: /fix-the-web');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <title>Fix the Web Front Panel</title> <!-- // TODO: Change title with suitable one-->
    <link rel="stylesheet" type="text/css" href="css/css.css">
</head>
<body>
    <?php
        if ($logged_in) echo '<div id="user">You are logged in as @<strong>' . $twitter_name . '</strong>. <a href="?logout" title="Logout of Fix the Web" class="go-button">logout</a></div>';
        else echo '<div id="user"><strong>You are not logged in.</strong> <a href="?login" title="Login to Fix the Web with your Twitter Account" class="go-button">login with Twitter</a></div>';
    ?>
    <header>
        <h1>Fix the Web</h1>
        <div id="explanation-about-the-extension">
            <h2>
                What is Fix the Web?
            </h2>
            <p>
                <strong>Fix the Web</strong> is an Opera Web Browser extension. As hinted by its name, its goal is to promote a
                <em>World Wide Web</em> built on solid, standards-conforming web development practices.  
            </p>
            
            <p>
                Many web sites contain malformed HTML and archaic or poorly-designed Javascript. Some websites use bad web development 
                practices such as browser-sniffing. Consequently, these pages could produce visual flaws, functional glitches, or even worse, 
                be completely nonfunctional in Opera, a standards-conforming web browser. 
            </p><p>
                The goal of Fix the Web is to provide a solution to these problems by allowing users to report site problems they encounter, 
                reply to others' bug reports, and, most importantly, apply patches to broken web pages.
            </p>
        </div>
        <div id="more-detail-about-project">More</div>
        <p style="clear:both;"></p>
    </header>
    <section>    
    </section>
        <aside>
            
            <h2>Listing Options</h2>
        
            <form action="?" id="form">

                <label for="domain">Domain
                    <input type="text" name="domain" id="domain" placeholder="Enter a domain name" <?php if(isset($_GET['domain'])) echo "value=".$_GET['domain'];?>>
                </label>
                <button type="submit">Submit</button>
            </form>
            <div>
                <ul>
                    <li><a href="?mode=get_report_list&order=popularity" id="most-popular-reports">Most Popular Reports</a></li>
                    <li><a href="?mode=get_report_list&order=most_followed" id="most-followed-reports">Most Followed Reports</a></li>
                </ul>
            </div>
        </aside>
        <script type="text/javascript" src="js/js.js"></script>
    </body>
</html>