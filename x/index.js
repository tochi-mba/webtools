const defaultConfig = {
    remove_when_ended: true,
    show_seek_bar: true,
    autoplay: true,
    quick_switch_links: "https://www.youtube.com/",
    skip_seconds: 10,
  };

  chrome.storage.sync.get("configGoon", (data) => {
    const config = data.configGoon || defaultConfig;
    document.getElementById("remove_when_ended").checked =
      config.remove_when_ended;
    document.getElementById("show_seek_bar").checked = config.show_seek_bar;
    document.getElementById("autoplay").checked = config.autoplay;
    document.getElementById("quick_switch_links").value =
      config.quick_switch_links;
    document.getElementById("skip_seconds").value = config.skip_seconds;
  });
  document.getElementById("form").addEventListener("submit", (e) => {
    e.preventDefault();
    const form = e.target;
    console.log(form);
    const formData = new FormData(form);
    const config = {};
    for (const [key, value] of formData) {
      config[key] = value;
      console.log(key, value);
    }

    chrome.storage.sync.set({ configGoon: config }, () => {
      console.log("Settings saved.");
    });
  });


  document.getElementById("form").addEventListener("submit", (e) => {
    e.preventDefault();
    const form = e.target;
    console.log(form);
    const formData = new FormData(form);
    const config = {};
    for (const [key, value] of formData) {
      config[key] = value;
      console.log(key, value);
    }

    chrome.storage.sync.set({ configGoon: config }, () => {
      console.log("Settings saved.");
    });
  });

  document.getElementById("beer").addEventListener("click", () => {
    chrome.tabs.create({ url: "https://www.buymeacoffee.com/xlord" });
  });