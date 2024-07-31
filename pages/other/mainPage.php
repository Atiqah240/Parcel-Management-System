<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPARK System</title>
    <link rel="stylesheet" href="../../css/mainpage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <script defer src="activePage.js"></script>
</head>
<body>
    <div class="banner">
        <div class="navbar">
            <img class="logo" src="../../pictures/logoParcel.png" alt="SPARK Logo">
            <ul class="menu">
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#service">Services</a></li>
                <li><a href="#contactus">Contact Us</a></li>
                <li><a href="#about">About</a></li>
            </ul>
        </div>
        <div class="content">
            <h1>Welcome to SPARK</h1>
            <div>
                <a href="../../pages/other/loginAll.php">
                    <button type="button">Get Started</button>
                </a>
            </div>
        </div>
    </div>
    </body>

    <!-- (ib) Pricing Navbar  -->
    <body>
        <div class="section" id="pricing">
          <h1>Price for each size</h1>
          <div class="container">
            <a href="#" class="pic">
                <p>Small</p>
                <img src="../../pictures/smallParcel.png">
                <p>RM1</p>
            </a>
            <a href="#" class="pic">
                <p>Medium</p>
                <img src="../../pictures/medParcel.png">
                <p>RM2</p>
            </a>
            <a href="#" class="pic">
                <p>Large</p>
                <img src="../../pictures/bigParcel.png">
                <p>RM3</p>
            </a>
          </div>
      </div>
  </body>

  <!-- (aminah) Services that SPARK provided -->
  <body>
    <div class="section" id="service">
        <h2>SERVICES</h2>
        <hr>
        <div class="service">
            <div class="type">
                <img src="../../pictures/delivery.jpg">
                <h4>DELIVERY</h4>
                <p>RM 1/parcel</p>
            </div>
            <div class="type1">
                <img src="../../pictures/pickup.jpg">
                <h4>PICK UP</h4>
                <p>No Charge</p>
            </div>
        </div>
    </div>
  </body>

      <!-- (auni) Contact Us  -->
      <body>
      <div class="section" id="contactus">
    <div class="contact-section">
        <h2 class="contact-header">Contact Us</h2>
        
        <div class="contact-info">
            <img src="../../pictures/ibtisam.jpg" alt="IBTISAM BINTI ASRUL HAFIZ">
            <div>
                <p class="contact-name">IBTISAM BINTI ASRUL HAFIZ</p>
                <p class="contact-phone">(+6011-55507913)</p>
            </div>
        </div>
        
        <div class="contact-info">
            <img src="../../pictures/atiqah.jpg" alt="NUR ATIQAH ZULAIKA BINTI ISMAIL">
            <div>
                <p class="contact-name">NUR ATIQAH ZULAIKA BINTI ISMAIL</p>
                <p class="contact-phone">(+6018-2139632)</p>
            </div>
        </div>

        <div class="contact-info">
            <img src="../../pictures/auni.png" alt="NURUL AUNI BINTI MOHAMAD MOHLIS">
            <div>
                <p class="contact-name">NURUL AUNI BINTI MOHAMAD MOHLIS</p>
                <p class="contact-phone">(+6019-8142770)</p>
            </div>
        </div>

        <div class="contact-info">
            <img src="../../pictures/aminah.jpg" alt="SITI AMINAH BINTI AIDI">
            <div>
                <p class="contact-name">SITI AMINAH BINIT AIDI</p>
                <p class="contact-phone">(+6019-5819775)</p>
            </div>
        </div>
    </div>
</div>
      </body>

    <!-- (Aminah) About  -->
    <body>
      <div class="section" id="about">
        <section class="about-us"> 
            <div class="container">
                <div class="about-image">
                    <img src="../../pictures/logoParcel.png">
                </div>
                <div class="about-content">
                    <h1>ABOUT US</h1>
                    <p>SPARK SYSTEM was founded by a group of UiTM Raub students named Ibtisam, Atiqah, Aminah, and Auni. It was initially developed at UiTM Raub, where students discovered it. It is a mechanism that allows students to select whether to pick up their packages or have them delivered to their homes. After many thoughts and complaints, we decided to build this approach to make it easier for students to get their hands on their packages.</p>
                </div>
            </div>
        </section>
      </div>
    </body>


    <!-- Help Desk -->
    <body>
      <div class="box">
          <h1>SPARK FAQ</h1>

          <div class="faq-item">
              <button class="question">What is SPARK?</button>
              <div class="answer">SPARK, a parcel management service established by UiTM Kampus Raub, facilitates the distribution of online-ordered parcels for students. Established in 2016 to address the challenges students faced in parcel collection, SPARK is part of UiTM Raub's efforts to streamline and enhance the parcel pickup process, ensuring convenience and efficiency without disruption.</div>
          </div>

          <div class="faq-item">
              <button class="question">Benefits For Spark Users</button>
              <div class="answer">Spark provides UiTM Raub students with a highly convenient and efficient system for managing and receiving their parcels, ensuring a streamlined process that saves time and reduces hassle.</div>
          </div>
      </div>
    </body>
      
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = document.querySelectorAll('.question');

            questions.forEach(function (question) {
                question.addEventListener('click', function () {
                    const answer = this.nextElementSibling;
                    answer.style.display = (answer.style.display === 'block') ? 'none' : 'block';
                });
            });
        });
    </script>

    <!-- Enhanced Footer -->
    <footer style="background-color: #2C2C2C; color: white; padding: 40px 20px; font-family: Arial, sans-serif;">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; max-width: 1200px; margin: 0 auto;">

          <!-- Company Section -->
          <div style="flex: 1; min-width: 200px; margin: 10px;">
              <h3 style="border-bottom: 1px solid #8A2BE2; padding-bottom: 10px; color: white;">Company</h3>
              <ul style="list-style-type: none; padding: 10px;">
              <a><li style="color: #A9A9A9; margin-bottom: 10px;">About Us</li></a>
              <li style="color: #A9A9A9; margin-bottom: 10px;">Our Services</li>
              <li style="color: #A9A9A9; margin-bottom: 10px;">Privacy Policy</li>
            </ul>
          </div>

          <!-- Get Help Section -->
          <div style="flex: 1; min-width: 200px; margin: 10px;">
            <h3 style="border-bottom: 1px solid #8A2BE2; padding-bottom: 10px;">Get Help</h3>
            <ul style="list-style-type: none; padding: 10px;">
              <li><a href="#" style="color: #A9A9A9; text-decoration: none;">FAQ</a></li>
              <li><a href="#" style="color: #A9A9A9; text-decoration: none;">Order Status</a></li>
              <li><a href="#" style="color: #A9A9A9; text-decoration: none;">Payment Options</a></li>
            </ul>
          </div>

          <!-- Follow Us Section -->
          <div style="flex: 1; min-width: 200px; margin: 10px;">
            <h3 style="border-bottom: 1px solid #8A2BE2; padding-bottom: 10px;">Follow Us</h3>
            <ul style="list-style-type: none; padding: 10px; display: flex; gap: 10px;">
              <li><a href="#" style="color: white; text-decoration: none;"><img src="../../pictures/facebook.png" alt="Facebook" style="width: 24px;"></a></li>
              <li><a href="#" style="color: white; text-decoration: none;"><img src="../../pictures/twitter.png" alt="Twitter" style="width: 24px;"></a></li>
              <li><a href="#" style="color: white; text-decoration: none;"><img src="../../pictures/instagram.png" alt="Instagram" style="width: 24px;"></a></li>
              <li><a href="#" style="color: white; text-decoration: none;"><img src="../../pictures/linkedin.png" alt="LinkedIn" style="width: 24px;"></a></li>
            </ul>
          </div>

          <!-- Contact Section -->
          <div style="flex: 1; min-width: 200px; margin: 10px;">
            <h3 style="border-bottom: 1px solid #8A2BE2; padding-bottom: 10px;">Contact Us</h3>
            <ul style="list-style-type: none; padding: 10px;">
              <li style="color: #A9A9A9; margin-bottom: 10px;">UiTM Cawangan Kampus Raub</li>
              <li style="color: #A9A9A9; margin-bottom: 10px;">Email: <a href="mailto:info@company.com" style="color: #8A2BE2; text-decoration: none;">sparkSystem@com.my</a></li>
              <li style= "color: #A9A9A9">Phone: <a href="tel:+1234567890" style="color: #8A2BE2; text-decoration: none;">+60-123456789</a></li>
            </ul>
          </div>

        </div>
        <div style="text-align: center; margin-top: 20px; font-size: 14px;">
          <p>&copy; 2024 SPARK. All rights reserved.</p>
        </div>
      </footer>
</body>
</html>
