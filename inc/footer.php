<!-- This is the footer markup that we use to display the html markup in the pages that we need, we get this through the include function -->
<footer>
    <div class="footer">
        <div class="about-us-foot">
            <h2>About Us</h2>
            <div>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</div>
        </div>
        <div class="newsletter">
            <h2>Newsletter</h2>
            <p>Stay up to date:</p>
            <!-- this form submits the email to the newsletter.php file that adds the subscribers email to the newsletter table -->
            <form class="news-input" method="post" action="config/newsletter.php">
                <input type="email" name="email" placeholder="Email" required>
                <button class="newsletter-button" type="submit"><span><i class="fas fa-chevron-right"></i></span></button>
            </form>
        </div>
        <div class="social">
            <h2>Follow Us</h2>
            <p>Let us be social!</p>
            <a href="http://facebook.com"><i class="fa-brands fa-facebook-square fa-2xl"></i></a>
            <a href="http://instagram.com"><i class="fa-brands fa-instagram fa-2xl"></i></a>
            <a href="http://linkedin.com"><i class="fa-brands fa-linkedin fa-2xl"></i></a>
            <a href="http://youtube.com"><i class="fa-brands fa-youtube fa-2xl"></i></a>
        </div>
    </div>
    <div class="copyright">&copy; Copyright <i class="fa-solid fa-code"></i> Coder 2022</div>
</footer>