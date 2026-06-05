import { $ } from "./elements.js";

const path = "./video/";
const videos = ["video_1.mp4", "video_2.mp4", "video_3.mp4", "video_4.mp4"];
const element_video = $.querySelector(".home-presentacion video");

function changeVideo() {
  const randomIndex = Math.floor(Math.random() * videos.length);
  const selectedVideo = videos[randomIndex];
  element_video.src = path + selectedVideo;
}

changeVideo();