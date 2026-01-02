// // Hamburger Menu Toggle
// const hamburger = document.querySelector('.hamburger');
// const navlists = document.querySelector('.navlists');

// // Create hamburger spans
// hamburger.innerHTML = '<span></span>';

// hamburger.addEventListener('click', () => {
//   hamburger.classList.toggle('active');
//   navlists.classList.toggle('active');
// });

const hamburger = document.getElementById('hamburger');
const hamburgerList = document.querySelector('.hamburgerlist');
const hamLinks = document.querySelector('.hamlinks');
const closebtn = document.getElementById('close');

hamburger.addEventListener('click', ()=>{
  hamburgerList.style.display= 'block';
  hamLinks.style.display = "flex"
})
closebtn.addEventListener('click', ()=>{
    hamburgerList.style.display= 'none';
  hamLinks.style.display = "none"
})

// Carousel functionality
const carouselTrack = document.querySelector('.carousel-track');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const dotsContainer = document.querySelector('.carousel-dots');
const venueCards = document.querySelectorAll('.venue-card');

let currentIndex = 0;
let cardsPerView = 3;
let totalCards = venueCards.length;

// Calculate cards per view based on screen size
function updateCardsPerView() {
  if (window.innerWidth <= 768) {
    cardsPerView = 1;
  } else if (window.innerWidth <= 1200) {
    cardsPerView = 2;
  } else {
    cardsPerView = 3;
  }
  currentIndex = 0; // Reset to first slide
  updateCarousel();
  createDots();
}

// Create dots
function createDots() {
  dotsContainer.innerHTML = '';
  const totalDots = Math.ceil(totalCards / cardsPerView);
  
  for (let i = 0; i < totalDots; i++) {
    const dot = document.createElement('div');
    dot.classList.add('dot');
    if (i === currentIndex) dot.classList.add('active');
    dot.addEventListener('click', () => {
      currentIndex = i;
      updateCarousel();
    });
    dotsContainer.appendChild(dot);
  }
}

// Update carousel position
function updateCarousel() {
  // Use getBoundingClientRect for more accurate width calculation
  const cardWidth = venueCards[0].getBoundingClientRect().width;
  const gap = 40;
  
  // Calculate the exact offset
  const offset = -(currentIndex * cardsPerView * (cardWidth + gap));
  
  carouselTrack.style.transform = `translateX(${offset}px)`;
  
  // Update dots
  const dots = document.querySelectorAll('.dot');
  dots.forEach((dot, index) => {
    dot.classList.toggle('active', index === currentIndex);
  });
  
  // Update button states
  prevBtn.disabled = currentIndex === 0;
  const maxIndex = Math.ceil(totalCards / cardsPerView) - 1;
  nextBtn.disabled = currentIndex >= maxIndex;
}

// Navigation
prevBtn.addEventListener('click', () => {
  if (currentIndex > 0) {
    currentIndex--;
    updateCarousel();
  }
});

nextBtn.addEventListener('click', () => {
  const maxIndex = Math.ceil(totalCards / cardsPerView) - 1;
  if (currentIndex < maxIndex) {
    currentIndex++;
    updateCarousel();
  }
});

// Keyboard navigation
document.addEventListener('keydown', (e) => {
  if (e.key === 'ArrowLeft') {
    prevBtn.click();
  } else if (e.key === 'ArrowRight') {
    nextBtn.click();
  }
});

// Touch/Swipe support
let touchStartX = 0;
let touchEndX = 0;

carouselTrack.addEventListener('touchstart', (e) => {
  touchStartX = e.changedTouches[0].screenX;
});

carouselTrack.addEventListener('touchend', (e) => {
  touchEndX = e.changedTouches[0].screenX;
  handleSwipe();
});

function handleSwipe() {
  if (touchStartX - touchEndX > 50) {
    nextBtn.click();
  }
  if (touchEndX - touchStartX > 50) {
    prevBtn.click();
  }
}

// Modal functionality
const modal = document.getElementById('bookingModal');
const closeBtn = document.querySelector('.close');
const bookingForm = document.getElementById('bookingForm');
const selectedVenue = document.getElementById('selectedVenue');
const bookingDate = document.getElementById('bookingDate');
const bookButtons = document.querySelectorAll('.book-now-btn');

// Set minimum date to today
const today = new Date().toISOString().split('T')[0];
bookingDate.min = today;

// Open modal when clicking "Book Now"
bookButtons.forEach(button => {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    const venueName = this.dataset.venue;
    selectedVenue.textContent = venueName;
    modal.style.display = 'flex';
  });
});

// Close modal when clicking X button
closeBtn.addEventListener('click', function() {
  modal.style.display = 'none';
  bookingForm.reset();
});

// Close modal when clicking outside modal content
window.addEventListener('click', function(e) {
  if (e.target === modal) {
    modal.style.display = 'none';
    bookingForm.reset();
  }
});

// Handle form submission
bookingForm.addEventListener('submit', function(e) {
  e.preventDefault();
  
  const bookingDetails = {
    venue: selectedVenue.textContent,
    date: bookingDate.value,
    time: document.getElementById('bookingTime').value,
    department: document.getElementById('department').value
  };

  console.log('Booking Confirmed:', bookingDetails);
  alert(`Success! You have booked ${bookingDetails.venue} for ${bookingDetails.date} at ${bookingDetails.time}\nDepartment: ${bookingDetails.department}`);
  
  modal.style.display = 'none';
  bookingForm.reset();
});

// Initialize
window.addEventListener('resize', updateCardsPerView);
updateCardsPerView();