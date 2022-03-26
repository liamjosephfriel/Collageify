<p align="center">
  <img src="https://i.imgur.com/Ti770zg.png">
</p>

## About Collageify
Collageify is a  simple tool for creating album collages that reflect your Spotify activity. The inspiration for this tool comes from [Tapmuisc's great Last.FM album collage generator.](https://www.tapmusic.net/)

I started this project last year [with the release of my Spotify album collage generation tool](https://liam.scot/blog/spotify-album-collage-generator/) which Collageify is a rewrite of.  

The tool itself is built with PHP, using Twig for templating and Javascript for the collage rendering. Bootstrap is used for the HTML scaffolding and Gulp and NPM and used for handling JS packages.

The project makes use of the html2canvas and dom-to-image JS libraries.

## How it works

Collageify pulls from the users top 50 most played tracks over either several weeks (Spotify calls this "short term"), several weeks ("medium term") or several years ("long term"). From this data the algorithm counts the number of tracks from each album that appears and then ranks these albums by where the first track is found in this data. 

Essentially albums with the most tracks featured in the most listened to data will appear in the collage. If there's a tie in the number of tracks an album has in the collage it uses the ranking of the album tracks as a tiebreaker. 

Happy Collageifying!

<p align="center">
  <img src="https://i.imgur.com/Spt7gF9.jpg" height="300px" width="300px">
</p>
<p align="center">
    <i>An example collage of mine</i>
</p>

## Links

* https://liam.scot/projects/collageify/
* https://liam.scot/blog/
