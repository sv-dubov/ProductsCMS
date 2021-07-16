<?php

include_once "content/page_header.php";
include_once "content/nav_bar.php";

?>

<section>
    <h1>Your profile</h1>
    <div id="profile_wrapper">
        <div id="profile_content">
            <p class="profile_content_p"><b>Login: </b><?php echo $_SESSION['user_data']['user_login']; ?></p>
            <p class="profile_content_p"><b>Balance: </b><?php echo check_balance($connect); ?></p>
            <p class="profile_content_p"><b>Registration date:
                </b><?php echo $_SESSION['user_data']['user_data_reg']; ?>
            </p>
            <div>
                <h2>List of purchased goods:</h2>
                <?php goods_list($connect); ?>
            </div>
        </div>
    </div>
</section>

<?php

include_once "content/page_footer.php";

?>
