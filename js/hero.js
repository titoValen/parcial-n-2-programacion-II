import { $ } from "./elements.js";

const videoPath = "video/";
const videos = ["video_1.webm", "video_2.webm", "video_3.webm", "video_4.webm"];
const element_video = $.querySelector(".home-presentacion video");

function changeVideo() {
  if (!element_video) return;

  const randomIndex = Math.floor(Math.random() * videos.length);
  const selectedVideo = videos[randomIndex];
  element_video.src = `${videoPath}${selectedVideo}`;
  element_video.load();
  element_video.play().catch(() => {});
}

changeVideo();