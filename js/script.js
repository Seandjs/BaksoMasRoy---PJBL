
let currentOutlet = 0;s
const outlets = document.querySelectorAll(".info-lokasi");
const indicators = document.querySelectorAll(".indicator-dot");
const nextButton = document.getElementById("nextOutlet");
const prevButton = document.getElementById("prevOutlet");
const mapFrame = document.getElementById("mapFrame");

function updateButtons() {
  if (currentOutlet === 0) {
    prevButton.style.display = "none";
    nextButton.style.display = "block";
  } else if (currentOutlet === outlets.length - 1) {
    prevButton.style.display = "block";
    nextButton.style.display = "none";
  } else {
    prevButton.style.display = "block";
    nextButton.style.display = "block";
  }
}

function showOutlet(index) {
  outlets.forEach((outlet, i) => {
    outlet.classList.remove("active");
    indicators[i].classList.remove("active");
  });

  outlets[index].classList.add("active");
  indicators[index].classList.add("active");

  const mapSrc = outlets[index].getAttribute("data-map");
  if (mapSrc) {
    mapFrame.src = mapSrc;
  }
  updateButtons();
}

nextButton.addEventListener("click", () => {
  if (currentOutlet < outlets.length - 1) {
    currentOutlet++;
    showOutlet(currentOutlet);
  }
});

prevButton.addEventListener("click", () => {
  if (currentOutlet > 0) {
    currentOutlet--;
    showOutlet(currentOutlet);
  }
});

indicators.forEach((indicator, index) => {
  indicator.addEventListener("click", () => {
    currentOutlet = index;
    showOutlet(currentOutlet);
  });
});

updateButtons();

// 3D PRODUCT EFFECT
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

// LANGUAGE DROPDOWN
const languageButton = document.getElementById("language");
const languageDropdown = document.getElementById("languageDropdown");

// USER DROPDOWN
const userButton = document.getElementById("user");
const userDropdown = document.getElementById("userDropdown");

if (languageButton && languageDropdown) {
  languageButton.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    // JIKA USER DROPDOWN SEDANG AKTIF → CLOSE DULU
    if (userDropdown && userDropdown.classList.contains("active")) {
      userDropdown.classList.remove("active");
    }

    languageDropdown.classList.toggle("active");
  });

  document.addEventListener("click", function (e) {
    if (
      !languageButton.contains(e.target) &&
      !languageDropdown.contains(e.target)
    ) {
      languageDropdown.classList.remove("active");
    }
  });

  languageDropdown.addEventListener("click", function (e) {
    e.stopPropagation();
  });
}

if (userButton && userDropdown) {
  userButton.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    // JIKA LANGUAGE DROPDOWN SEDANG AKTIF → CLOSE DULU
    if (languageDropdown && languageDropdown.classList.contains("active")) {
      languageDropdown.classList.remove("active");
    }

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

// HAMBURGER MENU TOGGLE
const hamburgerMenu = document.getElementById("menu");
const navbarNav = document.getElementById("navbarNav");

if (hamburgerMenu && navbarNav) {
  hamburgerMenu.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    navbarNav.classList.toggle("active");

    if (navbarNav.classList.contains("active")) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "auto";
    }
  });

  document.addEventListener("click", function (e) {
    if (!hamburgerMenu.contains(e.target) && !navbarNav.contains(e.target)) {
      navbarNav.classList.remove("active");
      document.body.style.overflow = "auto";
    }
  });

  navbarNav.addEventListener("click", function (e) {
    const rect = navbarNav.getBoundingClientRect();
    const clickX = e.clientX - rect.left;
    const clickY = e.clientY - rect.top;

    if (
      clickX > rect.width - 65 &&
      clickX < rect.width - 25 &&
      clickY > 20 &&
      clickY < 60
    ) {
      navbarNav.classList.remove("active");
      document.body.style.overflow = "auto";
    }
  });

  const navLinks = navbarNav.querySelectorAll("a");
  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      navbarNav.classList.remove("active");
      document.body.style.overflow = "auto";
    });
  });
}

const signupBtn = document.querySelector('a[href="#signup"]');
const popupSignup = document.getElementById("popupSignup");
const closeSignup = document.getElementById("closeSignup");

signupBtn.addEventListener("click", (e) => {
  e.preventDefault();
  popupSignup.style.display = "flex";
});

closeSignup.addEventListener("click", () => {
  popupSignup.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === popupSignup) {
    popupSignup.style.display = "none";
  }
});

const loginBtn = document.querySelector('a[href="#login"]');
const popupLogin = document.getElementById("popupLogin");
const closeLogin = document.getElementById("closeLogin");

loginBtn.addEventListener("click", (e) => {
  e.preventDefault();
  popupLogin.style.display = "flex";
});

closeLogin.addEventListener("click", () => {
  popupLogin.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === popupLogin) {
    popupLogin.style.display = "none";
  }
});

const inputSandi = document.getElementById("sandi-daftar");
const toggleBtn = document.getElementById("toggle-sandi");

inputSandi.addEventListener("input", () => {
  toggleBtn.style.display = inputSandi.value.length > 0 ? "block" : "none";
});

toggleBtn.addEventListener("click", () => {
  const isHidden = inputSandi.type === "password";
  inputSandi.type = isHidden ? "text" : "password";
  toggleBtn.setAttribute("aria-pressed", isHidden);
  toggleBtn.innerHTML = isHidden
    ? '<i class="fa-regular fa-eye-slash"></i>'
    : '<i class="fa-regular fa-eye"></i>';
});
