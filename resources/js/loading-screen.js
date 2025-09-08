// Function to fade out loading screen
function fadeOutLoadingScreen() {
    const loadingScreen = document.getElementById("loading-screen");
    const content = document.getElementById("content");

    // Fade out loading screen
    loadingScreen.style.opacity = "0";

    // After fade animation completes, hide loading screen and show content
    setTimeout(() => {
        loadingScreen.style.display = "none";
        content.style.display = "block";
    }, 500); // 1000ms = 1s (duration of fade effect)
}

// Wait for all content to load before fading out loading screen
window.addEventListener("load", () => {
    // Add a small delay to ensure everything is rendered properly
    setTimeout(fadeOutLoadingScreen, 500);
});