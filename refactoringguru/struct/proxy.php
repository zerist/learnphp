<?php
namespace zerist\struct\proxy;

//proxy interface
interface ThirdPartyTVLib {
    function listVideos();
    function getVideoInfo(int $id);
    function downloadVideo(int $id);
}


