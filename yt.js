// Get all elements with class ytp-ad-text
var adTextElements = document.getElementsByClassName('ytp-ad-text');

// Get all video elements on the page
var videoElements = document.getElementsByTagName('video');

// Find the biggest video element
var biggestVideoElement = null;
var biggestVideoSize = 0;
for (var i = 0; i < videoElements.length; i++) {
  var videoElementSize = videoElements[i].offsetWidth * videoElements[i].offsetHeight;
  if (videoElementSize > biggestVideoSize) {
    biggestVideoSize = videoElementSize;
    biggestVideoElement = videoElements[i];
  }
}

// If there are elements with class ytp-ad-text and a video element is found, skip the biggest video element to the end
if (adTextElements.length > 0 && biggestVideoElement) {
  biggestVideoElement.currentTime = biggestVideoElement.duration;
  while (biggestVideoElement.currentTime != biggestVideoElement.duration) {
    document.querySelector("#skip-button\\:1j > span > button").click();

  }
}
