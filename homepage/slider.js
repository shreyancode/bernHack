fetch("/bernhack/backend/get_events.php")
  .then(response => response.json())
  .then(events => {
    const wrapper = document.getElementById("eventSlider");

    events.forEach(event => {
      const slide = document.createElement("div");
      slide.classList.add("swiper-slide");

      slide.innerHTML = `
        <img src="${event.image_path}" alt="">
        <div class="swiper-text">
          <h5>${event.title}</h5>
          <p>${event.description}</p>
        </div>
      `;

      wrapper.appendChild(slide);
    });

    new Swiper(".home-slider", {
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  })
  .catch(error => console.error("Error fetching events:", error));
