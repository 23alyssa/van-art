<?php

//header.php has information for bootstrap and page title
require('utilities/header.php');

//functions.php contains all the helper functions to make the form and display the table
require('utilities/functions.php');

?>


<!-- Carousel -->
<!-- <section> 
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img class="d-block w-25" src="https://opendata.vancouver.ca/api/v2/catalog/datasets/public-art/files/474f32613a9576400ec109ba2736fcfd" alt="First slide">
        </div>
        <div class="carousel-item">
        <img class="d-block w-25" src="https://opendata.vancouver.ca/api/v2/catalog/datasets/public-art/files/474f32613a9576400ec109ba2736fcfd" alt="Second slide">
        </div>
        <div class="carousel-item">
        <img class="d-block w-25" src="https://opendata.vancouver.ca/api/v2/catalog/datasets/public-art/files/474f32613a9576400ec109ba2736fcfd" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
</section>  -->

<div class="row" data-masonry="{&quot;percentPosition&quot;: true }" style="position: relative; height: 714px;">
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 0%; top: 0px;">
      <div class="card">
        <svg class="bd-placeholder-img card-img-top" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>

        <div class="card-body">
          <h5 class="card-title">Card title that wraps to a new line</h5>
          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 33.3333%; top: 0px;">
      <div class="card p-3">
        <figure class="p-3 mb-0">
          <blockquote class="blockquote">
            <p>A well-known quote, contained in a blockquote element.</p>
          </blockquote>
          <figcaption class="blockquote-footer mb-0 text-muted">
            Someone famous in <cite title="Source Title">Source Title</cite>
          </figcaption>
        </figure>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 66.6667%; top: 0px;">
      <div class="card">
        <svg class="bd-placeholder-img card-img-top" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text></svg>

        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 33.3333%; top: 171px;">
      <div class="card bg-primary text-white text-center p-3">
        <figure class="mb-0">
          <blockquote class="blockquote">
            <p>A well-known quote, contained in a blockquote element.</p>
          </blockquote>
          <figcaption class="blockquote-footer mb-0 text-white">
            Someone famous in <cite title="Source Title">Source Title</cite>
          </figcaption>
        </figure>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 33.3333%; top: 310px;">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This card has a regular title and short paragraph of text below it.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 0%; top: 362px;">
      <div class="card">
        <svg class="bd-placeholder-img card-img" width="100%" height="260" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Card image" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Card image</text></svg>

      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 66.6667%; top: 378px;">
      <div class="card p-3 text-end">
        <figure class="mb-0">
          <blockquote class="blockquote">
            <p>A well-known quote, contained in a blockquote element.</p>
          </blockquote>
          <figcaption class="blockquote-footer mb-0 text-muted">
            Someone famous in <cite title="Source Title">Source Title</cite>
          </figcaption>
        </figure>
      </div>
    </div>
    <div class="col-sm-6 col-lg-4 mb-4" style="position: absolute; left: 33.3333%; top: 488px;">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>
  </div>
        </div>
    </div>
</section>