function startCountdown(eventDateTime, elementId) {
  const timerElement = document.getElementById(elementId);

  const updateTimer = () => {
    const now = new Date();
    const distance = eventDateTime - now;

    if (distance <= 0) {
      const card = timerElement.closest(".swiper-slide");
      if (card) card.remove();
      clearInterval(intervalId);
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    timerElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
  };

  updateTimer();
  const intervalId = setInterval(updateTimer, 1000);
}

fetch("/bernhack/backend/get_events.php")
  .then(response => response.json())
  .then(events => {
    const wrapper = document.getElementById("eventSlider");

    events.forEach(event => {
      const slide = document.createElement("div");
      slide.classList.add("swiper-slide");
  const eventDateTime = new Date(`${event.date}T${event.time}`);
   const timerId = `timer-${event.id}`;
    slide.innerHTML = `
    <div class="image">
  <img src="${event.image_path}" alt="">
  </div>
  <div class="swiper-text">
    <h5>${event.title}</h5>
    <p>${event.description}</p>
    <p>Starts in: <span id="${timerId}" class="timer">Loading...</span></p>
    <a href="/bernhack/backend/displayForms.php?event_id=${event.id}" class="register-btn">Register</a>
  </div>
`;

      wrapper.appendChild(slide);
       startCountdown(eventDateTime, timerId);
    }
  );

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
