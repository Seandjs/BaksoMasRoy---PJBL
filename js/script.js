const outlets = document.querySelectorAll(".info-lokasi");
const nextButton = document.getElementById("nextOutlet");
let currentIndex = 0;

function showOutlet(index) {
  outlets.forEach((el, i) => {
    el.classList.remove("active");
    if (i === index) {
      el.classList.add("active");
    }
  });
}

nextButton.addEventListener("click", () => {
  currentIndex = (currentIndex + 1) % outlets.length;
  showOutlet(currentIndex);
});

showOutlet(currentIndex);

// 3D PRODUCT EFFECT - FIXED
const produkItems = document.querySelectorAll(".produk-item");

produkItems.forEach((item) => {
  const container = item.querySelector(".container");
  let isHovering = false;

  item.addEventListener("mouseenter", () => {
    isHovering = true;
  });

  item.addEventListener("mousemove", (e) => {
    if (!isHovering) return;

    const rect = item.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const rotateX = (y - centerY) / 10;
    const rotateY = (centerX - x) / 10;

    container.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
  });

  item.addEventListener("mouseleave", () => {
    isHovering = false;
    container.style.transform = "rotateX(0) rotateY(0)";
  });
});

// AUDIO CONTROLS
const audio = document.getElementById("backgroundAudio");
const muteButton = document.getElementById("muteButton");
const volumePanel = document.getElementById("volumePanel");
const volumeSlider = document.getElementById("volumeSlider");
const volumeText = document.getElementById("volumeText");

let isMuted = false;
let isPlaying = false;
let previousVolume = 50;
let panelVisible = false;

audio.volume = 0.5;

window.addEventListener("load", () => {
  audio
    .play()
    .then(() => {
      isPlaying = true;
      console.log("Audio autoplay started");
    })
    .catch((e) => {
      console.log("Autoplay prevented by browser");
      document.addEventListener(
        "click",
        () => {
          if (!isPlaying) {
            audio
              .play()
              .then(() => {
                isPlaying = true;
                console.log("Audio started on user interaction");
              })
              .catch((err) => console.log("Audio play failed:", err));
          }
        },
        { once: true }
      );
    });
});

muteButton.addEventListener("click", () => {
  if (!panelVisible) {
    showVolumePanel();
  } else {
    if (isMuted) {
      unmute();
    } else {
      mute();
    }
  }
});

function showVolumePanel() {
  volumePanel.classList.add("show");
  panelVisible = true;
}

function hideVolumePanel() {
  volumePanel.classList.remove("show");
  panelVisible = false;
}

function mute() {
  previousVolume = volumeSlider.value;
  audio.volume = 0;
  volumeSlider.value = 0;
  volumeText.textContent = "0%";
  muteButton.textContent = "🔇";
  muteButton.classList.add("muted");
  isMuted = true;
}

function unmute() {
  audio.volume = previousVolume / 100;
  volumeSlider.value = previousVolume;
  volumeText.textContent = previousVolume + "%";
  muteButton.textContent = "🔊";
  muteButton.classList.remove("muted");
  isMuted = false;
}

volumeSlider.addEventListener("input", function () {
  const volume = this.value;
  audio.volume = volume / 100;
  volumeText.textContent = volume + "%";

  if (volume == 0) {
    muteButton.textContent = "🔇";
    muteButton.classList.add("muted");
    isMuted = true;
  } else {
    muteButton.textContent = "🔊";
    muteButton.classList.remove("muted");
    isMuted = false;
    previousVolume = volume;
  }
});

volumePanel.addEventListener("mouseenter", () => {
  panelVisible = true;
});

document.addEventListener("click", (e) => {
  if (!e.target.closest(".audio-control")) {
    hideVolumePanel();
  }
});

const userButton = document.getElementById("user");
const userDropdown = document.getElementById("userDropdown");

if (userButton && userDropdown) {
  userButton.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    userDropdown.classList.toggle("active");
  });

  document.addEventListener("click", function (e) {
    if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
      userDropdown.classList.remove("active");
    }
  });

  userDropdown.addEventListener("click", function (e) {
    e.stopPropagation();
  });
}
