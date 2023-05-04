window.onload = () => {
    const defaultConfig = {
      remove_when_ended: true,
      show_seek_bar: true,
      autoplay: true,
      quick_switch_links: "https://www.youtube.com/",
      skip_seconds: 2,
    };
  
    chrome.storage.sync.get("configGoon", (data) => {
      const config = data.configGoon || defaultConfig;
      sessionStorage.setItem("configGoon", JSON.stringify(config));
    });
  
    function screens(videoContainer, videoFullscreen) {
      const playPause = document.createElement("div");
      playPause.style.position = "absolute";
      playPause.innerHTML = "⏸";
      playPause.style.backgroundColor = "black";
      playPause.style.top = "30px";
      playPause.style.left = "30px";
      playPause.style.zIndex = "10000";
      playPause.style.fontSize = "20px";
      playPause.style.color = "white";
      playPause.style.cursor = "pointer";
      playPause.style.display = "none";
      playPause.addEventListener("click", () => {
        if (videoFullscreen.paused) {
          videoFullscreen.play();
          playPause.innerHTML = "⏸";
          vid = JSON.parse(sessionStorage.getItem("vid"));
          vid.forEach((vid) => {
            if (vid.src === videoFullscreen.src) {
              vid.paused = false;
            }
          });
          sessionStorage.setItem("vid", JSON.stringify(vid));
        } else {
          videoFullscreen.pause();
          playPause.innerHTML = "▶";
          vid = JSON.parse(sessionStorage.getItem("vid"));
          vid.forEach((vid) => {
            if (vid.src === videoFullscreen.src) {
              vid.paused = true;
            }
          });
          sessionStorage.setItem("vid", JSON.stringify(vid));
        }
      });
  
      videoContainer.appendChild(playPause);
  
      const closeButton = document.createElement("button");
      closeButton.textContent = "×";
      closeButton.style.backgroundColor = "black";
      closeButton.style.display = "none";
      closeButton.style.color = "white";
      closeButton.style.fontSize = "20px";
      closeButton.style.position = "absolute";
      closeButton.style.top = "5px";
      closeButton.style.right = "5px";
      closeButton.style.zIndex = "10000";
      closeButton.style.cursor = "pointer";
      closeButton.addEventListener("click", () => {
        document.body.removeChild(videoContainer);
        vid = JSON.parse(sessionStorage.getItem("vid"));
        const index = vid.findIndex((vid) => vid.src === videoFullscreen.src);
        vid.splice(index, 1);
        sessionStorage.setItem("vid", JSON.stringify(vid));
      });
      videoContainer.appendChild(closeButton);
  
      if (
        sessionStorage.getItem("configGoon") &&
        JSON.parse(sessionStorage.getItem("configGoon")).show_seek_bar
      ) {
        // Create the container element
        const container = document.createElement("div");
        container.style.position = "absolute";
        container.style.bottom = "0";
        container.style.left = "0";
        container.style.width = "100%";
        container.style.height = "7px";
        videoContainer.appendChild(container);
  
        // Create the progress bar element
        const progress = document.createElement("div");
        progress.style.width = "100%";
        progress.style.height = "100%";
        progress.style.backgroundColor = "none";
        container.appendChild(progress);
  
        // Create the progress bar fill element
        const fill = document.createElement("div");
        fill.style.width = "0";
        fill.style.height = "100%";
        fill.style.backgroundColor = "#66140C";
        progress.appendChild(fill);
  
        // Update the fill width based on video time
      videoFullscreen.addEventListener("timeupdate", () => {
        const percent =
          (videoFullscreen.currentTime / videoFullscreen.duration) * 100;
        fill.style.width = `${percent}%`;
        vid = JSON.parse(sessionStorage.getItem("vid"));
        vid.forEach((vid) => {
          if (vid.src === videoFullscreen.src) {
            vid.timestamp = videoFullscreen.currentTime;
          }
        });
        sessionStorage.setItem("vid", JSON.stringify(vid));
      });
  
        // Add the container to the document
        videoContainer.appendChild(container);
      }
  
      // Update the fill width based on video time
      videoFullscreen.addEventListener("timeupdate", () => {
        vid = JSON.parse(sessionStorage.getItem("vid"));
        vid.forEach((vid) => {
          if (vid.src === videoFullscreen.src) {
            vid.timestamp = videoFullscreen.currentTime;
          }
        });
        sessionStorage.setItem("vid", JSON.stringify(vid));
      });
  
      const draggableArea = document.createElement("div");
      draggableArea.style.position = "absolute";
      draggableArea.style.top = "0";
      draggableArea.style.left = "0";
      draggableArea.style.width = "100%";
      draggableArea.style.height = "100%";
      draggableArea.style.cursor = "move";
      draggableArea.addEventListener("mousedown", (event) => {
        const startX = event.clientX;
        const startY = event.clientY;
        const videoContainerRect = videoContainer.getBoundingClientRect();
        const offsetX = startX - videoContainerRect.left;
        const offsetY = startY - videoContainerRect.top;
  
        const handleMouseMove = (event) => {
          const x = event.clientX - offsetX;
          const y = event.clientY - offsetY;
          videoContainer.style.top = `${y}px`;
          videoContainer.style.left = `${x}px`;
          vid = JSON.parse(sessionStorage.getItem("vid"));
          vid.forEach((vid) => {
            if (vid.src === videoFullscreen.src) {
              vid.top = y;
              vid.left = x;
            }
          });
          sessionStorage.setItem("vid", JSON.stringify(vid));
        };
        document.addEventListener("mousemove", handleMouseMove);
  
        const handleMouseUp = () => {
          document.removeEventListener("mousemove", handleMouseMove);
          document.removeEventListener("mouseup", handleMouseUp);
        };
        document.addEventListener("mouseup", handleMouseUp);
      });
      videoContainer.appendChild(draggableArea);
      videoContainer.addEventListener("mouseover", () => {
        playPause.style.display = "block";
        closeButton.style.display = "block";
      });
  
      videoContainer.addEventListener("mouseout", () => {
        playPause.style.display = "none";
        closeButton.style.display = "none";
      });
      videos = document.querySelectorAll(".video-container-fullscreen");
  
      videos.forEach((video) => {
        video.addEventListener("click", () => {
          zIndexes = [];
          vid = JSON.parse(sessionStorage.getItem("vid"));
  
          videos.forEach((video1) => {
            zIndexes.push(parseInt(video1.style.zIndex));
          });
          maxZIndex = Math.max(...zIndexes);
          video.style.zIndex = maxZIndex + 1;
          vid.forEach((vid) => {
            if (vid.src === videoFullscreen.src) {
              vid.zIndex = maxZIndex + 1;
            }
          });
          sessionStorage.setItem("vid", JSON.stringify(vid));
          videoSrc = video.querySelector("video");
          let isArrowPressed = false;
  
          document.addEventListener("keydown", (event) => {
            if (isArrowPressed) {
              return;
            }
  
            const skipSeconds = parseInt(
              JSON.parse(sessionStorage.getItem("configGoon")).skip_seconds
            );
            if (event.key === "ArrowRight" && !event.shiftKey) {
              setInterval(() => {
                event.preventDefault();
                videoSrc.currentTime += skipSeconds;
              }, 500);
             
            } else if (event.key === "ArrowLeft" && !event.shiftKey) {
              setInterval(() => {
                event.preventDefault();
                videoSrc.currentTime -= skipSeconds;
              }, 500);
            }
  
            isArrowPressed = true;
  
            setTimeout(() => {
              isArrowPressed = false;
            }, 1000);
          });
  
          // Skip forward 5 seconds when right arrow key is pressed
          document.addEventListener("keydown", (event) => {
            if (
              (event.key === " " || event.key === "Spacebar") &&
              !event.shiftKey
            ) {
              event.preventDefault();
  
              if (videoSrc.paused) {
                videoSrc.play();
                playPause.innerHTML = "⏸";
                vid = JSON.parse(sessionStorage.getItem("vid"));
                vid.forEach((vid) => {
                  if (vid.src === videoFullscreen.src) {
                    vid.paused = false;
                  }
                });
                sessionStorage.setItem("vid", JSON.stringify(vid));
              } else {
                videoSrc.pause();
                playPause.innerHTML = "▶";
                vid = JSON.parse(sessionStorage.getItem("vid"));
                vid.forEach((vid) => {
                  if (vid.src === videoFullscreen.src) {
                    vid.paused = true;
                  }
                });
                sessionStorage.setItem("vid", JSON.stringify(vid));
              }
            }
            // Skip forward 5 seconds when right arrow key is pressed
            else if (event.key === "ArrowRight" && !event.shiftKey) {
              skipSeconds1 = parseInt(
                JSON.parse(sessionStorage.getItem("configGoon")).skip_seconds
              );
              event.preventDefault();
              setInterval(() => {
                event.preventDefault();
                videoSrc.currentTime += skipSeconds1;
              }, 500);
            }
            // Skip backward 5 seconds when left arrow key is pressed
            else if (event.key === "ArrowLeft" && !event.shiftKey) {
              event.preventDefault();
              setInterval(() => {
                event.preventDefault();
                videoSrc.currentTime -= skipSeconds1;
              }, 500);
            } else if (event.key === "ArrowUp" && !event.shiftKey) {
              event.preventDefault();
  
              if (videoSrc.volume < 1) {
                video.muted = false;
                videoSrc.volume += 0.1;
                vids = JSON.parse(sessionStorage.getItem("vid"));
                vids.forEach((vid) => {
                  if (vid.src === videoFullscreen.src) {
                    vid.volume = videoSrc.volume;
                  }
                });
                sessionStorage.setItem("vid", JSON.stringify(vids));
              }
            } else if (event.key === "ArrowDown" && !event.shiftKey) {
              event.preventDefault();
  
              if (videoSrc.volume > 0) {
                video.muted = false;
                videoSrc.volume -= 0.1;
                vids = JSON.parse(sessionStorage.getItem("vid"));
                vids.forEach((vid) => {
                  if (vid.src === videoFullscreen.src) {
                    video.muted = false;
                    vid.volume = videoSrc.volume;
                  }
                });
                sessionStorage.setItem("vid", JSON.stringify(vids));
              }
            }
          });
        });
      });
  
      const resizables = document.querySelectorAll(".video-container-fullscreen");
  
      resizables.forEach((resizable) => {
        let isResizing = false;
        let lastX;
        let lastY;
  
        const handle = document.createElement("div");
        handle.style.zIndex = "99999999999999999999";
        handle.style.position = "absolute";
        handle.style.bottom = "0";
        handle.style.right = "0";
        handle.style.width = "50px";
        handle.style.height = "50px";
        handle.style.background = "none";
        handle.style.cursor = "se-resize";
  
        handle.className = "resize-handle";
        resizable.appendChild(handle);
  
        handle.addEventListener("mousedown", (e) => {
          e.preventDefault();
          isResizing = true;
          lastX = e.clientX;
          lastY = e.clientY;
        });
  
        document.addEventListener("mousemove", (e) => {
          if (!isResizing) return;
  
          const diffX = e.clientX - lastX;
          const diffY = e.clientY - lastY;
  
          const newWidth = resizable.offsetWidth + diffX;
          const newHeight = resizable.offsetHeight + diffY;
  
          resizable.style.width = `${newWidth}px`;
          resizable.style.height = "auto";
  
          lastX = e.clientX;
          lastY = e.clientY;
          vid = JSON.parse(sessionStorage.getItem("vid"));
          vid.forEach((vid) => {
            if (vid.src === videoFullscreen.src) {
              vid.width = newWidth;
              vid.height = newHeight;
            }
          });
          sessionStorage.setItem("vid", JSON.stringify(vid));
        });
  
        document.addEventListener("mouseup", () => {
          isResizing = false;
        });
      });
      videoFullscreen.addEventListener("ended", () => {
        if (
          sessionStorage.getItem("configGoon") &&
          JSON.parse(sessionStorage.getItem("configGoon")).remove_when_ended
        ) {
          document.body.removeChild(videoContainer);
          vid = JSON.parse(sessionStorage.getItem("vid"));
          const index = vid.findIndex((vid) => vid.src === videoFullscreen.src);
          vid.splice(index, 1);
          sessionStorage.setItem("vid", JSON.stringify(vid));
        }
      });
    }
    allSrc = [];
  
    function cont(logs) {
      logs.forEach((log) => {
        if (allSrc.includes(log.src)) {
          return;
        } else {
          allSrc.push(log.src);
        }
        const videoContainer = document.createElement("div");
        videoContainer.classList.add("video-container-fullscreen");
        videoContainer.style.position = "fixed";
        videoContainer.style.top = log.top + "px";
        videoContainer.style.left = log.left + "px";
        videoContainer.style.width = log.width + "px";
        videoContainer.style.height = "fit-content";
        videoContainer.style.zIndex = log.zIndex;
  
        document.body.appendChild(videoContainer);
  
        const videoFullscreen = document.createElement("video");
        videoFullscreen.src = log.src;
        if (!log.pause) {
          videoFullscreen.autoplay = true;
        }
        videoFullscreen.style.width = "100%";
        videoFullscreen.style.height = "auto";
        videoFullscreen.currentTime = log.timestamp;
        videoFullscreen.volume = log.volume;
        videoContainer.appendChild(videoFullscreen);
  
        screens(videoContainer, videoFullscreen);
      });
    }
  
    if (
      JSON.parse(sessionStorage.getItem("vid")) !== null &&
      sessionStorage.getItem("vid") !== "" &&
      sessionStorage.getItem("vid") !== "undefined"
    ) {
      cont(JSON.parse(sessionStorage.getItem("vid")));
    } else {
      sessionStorage.setItem("vid", JSON.stringify([]));
    }
  
    cont(JSON.parse(sessionStorage.getItem("vid")));
    function func(logs) {
      vid = JSON.parse(sessionStorage.getItem("vid"));
  
      vid.forEach((vid) => {
        if (vid.src === logs[0]) {
          return;
        }
      });
  
      done = true;
      sessionStorage.setItem("paused", "false");
      sessionStorage.setItem("muted", "false");
  
      vid = JSON.parse(sessionStorage.getItem("vid"));
      vid.push({
        src: logs[0],
        width: 200,
        height: 0,
        timestamp: 0,
        zIndex: 2000000000,
        paused: false,
        top: 0,
        left: 0,
        volume: 1,
      });
      sessionStorage.setItem("vid", JSON.stringify(vid));
  
      const videoContainer = document.createElement("div");
      videoContainer.classList.add("video-container-fullscreen");
      videoContainer.style.position = "fixed";
      videoContainer.style.top = "0";
      videoContainer.style.left = "0";
      videoContainer.style.width = "200px";
      videoContainer.style.height = "fit-content";
  
      videoContainer.style.zIndex = "2000000000";
  
      document.body.appendChild(videoContainer);
  
      const videoFullscreen = document.createElement("video");
      videoFullscreen.src = logs[0];
      if (
        sessionStorage.getItem("configGoon") &&
        JSON.parse(sessionStorage.getItem("configGoon")).autoplay
      ) {
        videoFullscreen.autoplay = true;
      }
      videoFullscreen.style.width = "100%";
      videoFullscreen.style.height = "auto";
  
      videoContainer.appendChild(videoFullscreen);
  
      screens(videoContainer, videoFullscreen);
    }
  
    async function funcy() {
      await new Promise((resolve) => {
        setTimeout(() => {
          resolve();
        }, 1000);
      });
      logs = [];
      videos = document.querySelectorAll("video");
      videos.forEach((video) => {
        logs.push(video.src);
      });
      func(logs);
    }
    document.body.style.userSelect = "none";
    // select all elements with class "report-control"
    try {
      document
        .querySelector("#player_wrapper_outer > div.play_cover > span.i-play")
        .click();
    } catch (error) {
      console.log(error);
    }
  
    const reportControls = document.querySelectorAll(".video_toolbar");
  
    // loop through the elements and append the new HTML element
    reportControls.forEach((reportControl) => {
      // create button element
      var button = document.createElement("button");
  
      // set button attributes
      button.style.backgroundColor = "grey";
      button.style.padding = "5px";
      button.style.zIndex = "2147483647";
      button.style.position = "absolute";
      button.style.right = "50%";
      button.style.fontSize = "15px";
      button.style.color = "white";
      button.style.fontWeight = "bolder";
      button.style.borderRadius = "5px";
      button.style.cursor = "pointer";
      button.style.bottom = "55px";
      button.textContent = "+";
  
      // add event listener to button
      button.addEventListener("click", funcy);
  
      // append button to the document body
      reportControl.appendChild(button);
    });
    document.querySelectorAll(".video-item").forEach((vid) => {
      plus = document.createElement("button");
      plus.style.backgroundColor = "grey";
      plus.style.padding = "5px";
      plus.style.zIndex = "999";
      plus.style.position = "absolute";
      plus.style.right = "50%";
      plus.style.fontSize = "15px";
      plus.style.color = "white";
      plus.style.fontWeight = "bolder";
      plus.style.borderRadius = "5px";
      plus.style.cursor = "pointer";
      plus.style.bottom = "55px";
      plus.innerHTML = "+";
      vid.appendChild(plus);
  
      plus.addEventListener("click", () => {
        xhr = new XMLHttpRequest();
        xhr.open("GET", vid.querySelector("a").href);
        xhr.onload = function () {
          if (xhr.status === 200) {
            const html = xhr.responseText;
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");
            const videoRelated = doc.querySelector("video");
            src = videoRelated.querySelector("source").src;
            func([src]);
          } else {
            console.error("Request failed. Status code: " + xhr.status);
          }
        };
        xhr.send();
      });
    });
    try {
      recs = document.querySelector("#video > div.right > div > div");
  
      recs.querySelectorAll("div").forEach((rec) => {
        plus = document.createElement("button");
        plus.style.backgroundColor = "grey";
        plus.style.padding = "5px";
        plus.style.zIndex = "999";
        plus.style.position = "absolute";
        plus.style.right = "50%";
        plus.style.fontSize = "15px";
        plus.style.color = "white";
        plus.style.fontWeight = "bolder";
        plus.style.borderRadius = "5px";
        plus.style.cursor = "pointer";
        plus.style.bottom = "55px";
        plus.textContent = "+";
        rec.appendChild(plus);
  
        plus.addEventListener("click", () => {
          xhr = new XMLHttpRequest();
          xhr.open("GET", rec.querySelector("a").href);
          xhr.onload = function () {
            if (xhr.status === 200) {
              const html = xhr.responseText;
              const parser = new DOMParser();
              const doc = parser.parseFromString(html, "text/html");
              const videoRelated = doc.querySelector("video");
              src = videoRelated.querySelector("source").src;
              func([src]);
            } else {
              console.error("Request failed. Status code: " + xhr.status);
            }
          };
          xhr.send();
        });
      });
    } catch (error) {
      console.log(error);
    }
  };
  
  document.addEventListener("keydown", (event) => {
    if (event.key === "p") {
      paused = sessionStorage.getItem("paused");
      vids = document.querySelectorAll("video");
      vids.forEach((vid) => {
        if (paused === "true") {
          vid.pause();
        } else {
          vid.play();
        }
      });
      if (paused === "true") {
        sessionStorage.setItem("paused", "false");
      } else {
        sessionStorage.setItem("paused", "true");
      }
    }
  });
  
  document.addEventListener("keydown", (event) => {
    if (event.key === "c") {
      vids = document.querySelectorAll(".video-container-fullscreen");
      vids.forEach((vid) => {
        btns = vid.querySelectorAll("button");
        btns.forEach((btn) => {
          btn.click();
        });
      });
    }
  });
  
  document.addEventListener("keydown", (e) => {
    const quickSwitchLink = JSON.parse(
      sessionStorage.getItem("configGoon")
    ).quick_switch_links;
  
    if (e.key === "q") {
      videos = document.querySelectorAll("video");
      videos.forEach((v) => {
        v.pause();
      });
  
      const icon = document.querySelector('link[rel="icon"]');
  
      // Change the href attribute to the new icon file
      icon.href =
        "https://www.iconpacks.net/icons/2/free-youtube-logo-icon-2431-thumb.png";
      window.open(quickSwitchLink, "_blank");
    }
  });
  
  document.addEventListener("keydown", (event) => {
    if (event.key === "m") {
      muted = sessionStorage.getItem("muted");
      vids = document.querySelectorAll("video");
      vids.forEach((vid) => {
        if (muted === "true") {
          vid.muted = false;
        } else {
          vid.muted = true;
        }
      });
      if (muted === "true") {
        sessionStorage.setItem("muted", "false");
      } else {
        sessionStorage.setItem("muted", "true");
      }
    }
  });
  