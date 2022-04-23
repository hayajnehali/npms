    <!-- Start Footer -->
    <div class="footer">
        <div class="row">
            <div class="col-md-4">
                <img src="../users/layout/image/logo-modified.png" class="footer-img" alt="">
            </div>
            <div class="col-md-8 Copyright">
                
                <p>
                    <form class="feedback-form" method="POST">
                        <input type="text" name="feedback" placeholder="Write Feedback About NPMS" class="Feedback-Text">
                        <button class="feedback-btn" name="add_feedbak">Sent</button>
                    </form>

                </p>
                <br>
                <p>Copyright &copy; 2022 All rights reserved | This site is made with by AMA & Re-distributed by college IT</p>
            
            </div>
        </div>
    </div>
<!-- End Footer -->
</div>

<?php
    $user_id = $_SESSION['user_id'];
    if(isset($_POST['add_feedbak']))
    {
        $feedback = $_POST['feedback'];

        $stmt = $con->prepare("INSERT INTO `feedback`(`feedback`, `user_id`) VALUES (:zfeed , :zuserid )");
        $stmt->execute(array(
            'zfeed' => $feedback,
            'zuserid' => $user_id

        ));
        echo '<script>alert("Inserted Feedback")</script>';
    }

?>




<script src="../users/layout/js/jquery-1.12.4.min.js"></script>
<script src="../users/layout/js/bootstrap.min.js"></script>
<script src="script.js"></script>

</body>
</html>