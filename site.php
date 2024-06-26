<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Portfolio</title>
    <link rel="stylesheet" href="test.css" />
    <link rel="stylesheet" href="mediaqueries.css" />
  </head>
  <body>
    <nav id="desktop-nav">
      <div class="logo">Med Club</div>
      <div>
       
      </div>
    </nav>
    <nav id="hamburger-nav">
      <div class="logo">Med Club</div>
      <div class="hamburger-menu">
        <div class="hamburger-icon" onclick="toggleMenu()">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="menu-links">
          <li><a href="#about" onclick="toggleMenu()">About</a></li>
          <li><a href="#experience" onclick="toggleMenu()">Experience</a></li>
          <li><a href="#projects" onclick="toggleMenu()">Projects</a></li>
          <li><a href="#contact" onclick="toggleMenu()">Contact</a></li>
        </div>
      </div>
    </nav>

    <section id="about">
      <p class="section__text__p1">Out  Your Comfort Zone</p>
      <h1 class="title">Welcome</h1>
      <div class="section-container">
       
        <div class="about-details-container">
          <div class="about-containers">
            <div class="details-container">
              <img
                src="./assets/experience.png"
                alt="Experience icon"
                class="icon"
              />
              <h3>Event way </h3>
              <p>Follow your <br />Dream</p>
            </div>
            <div class="details-container">
              <img
                src="./assets/education.png"
                alt="Education icon"
                class="icon"
              />
              <h3>Our Clubs</h3>
              <p>All in <br />One</p>
            </div>
          </div>
          <div class="text-container">
            <p>

            </p>
          </div>
        </div>
      </div>
      <img
        src="./assets/arrow.png"
        alt="Arrow icon"
        class="icon arrow"
        onclick="location.href='./#experience'"
      />
    </section>
    