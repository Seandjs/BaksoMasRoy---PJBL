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

// const products = document.querySelectorAll(".produk");

// products.forEach((produk) => {
//   const produkInner = produk.querySelector(".container");

//   produk.addEventListener("mousemove", (e) => {
//     const rect = produk.getBoundingClientRect();
//     const x = e.clientX - rect.left;
//     const y = e.clientY - rect.top;

//     const centerX = rect.width / 2;
//     const centerY = rect.height / 2;

//     const rotateX = (y - centerY) / 15;
//     const rotateY = (centerX - x) / 15;

//     produkInner.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
//   });

//   produk.addEventListener("mouseleave", () => {
//     produkInner.style.transform = "rotateX(0) rotateY(0) scale3d(1, 1, 1)";
//   });
// });

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
      console.log(
        "Autoplay prevented by browser, will try on user interaction"
      );
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

function toggleMute() {
  if (!panelVisible) {
    showVolumePanel();
  } else {
    if (isMuted) {
      unmute();
    } else {
      mute();
    }
  }
}

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

function playAudio() {
  audio
    .play()
    .then(() => {
      isPlaying = true;
      console.log("Audio started playing");
    })
    .catch((e) => {
      console.log("Audio play failed:", e);
      alert("Tidak bisa memutar audio. Coba klik tombol Play Audio lagi.");
    });
}

function startExperience() {
  playAudio();
  alert(
    "Pengalaman dimulai! Gunakan kontrol audio di kiri bawah untuk mengatur volume."
  );
}

audio.addEventListener("canplay", () => {
  console.log("Audio ready to play");
});

audio.addEventListener("error", (e) => {
  console.log("Audio error:", e);
  createDemoTone();
});

function createDemoTone() {
  try {
    const audioContext = new (window.AudioContext ||
      window.webkitAudioContext)();
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();

    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);

    oscillator.frequency.setValueAtTime(440, audioContext.currentTime);
    oscillator.type = "sine";
    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);

    volumeSlider.addEventListener("input", function () {
      const volume = this.value / 100;
      gainNode.gain.setValueAtTime(volume * 0.1, audioContext.currentTime);
    });

    oscillator.start();
    console.log("Demo tone created");
  } catch (e) {
    console.log("Web Audio API not supported");
  }
}
