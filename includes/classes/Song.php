<?php 

    class Song {

		private $con;
        private $id;
        private $mySqliData;
        private $title;
        private $artistId;
        private $albumId;
        private $genre;
        private $duration;
        private $path;

		public function __construct($con, $id) {
            $this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
            $this->mySqliData = mysqli_fetch_array($query);
            $this->title = $this->mySqliData['title'];
            $this->artistId = $this->mySqliData['artist'];
            $this->albumId = $this->mySqliData['album'];
            $this->genre = $this->mySqliData['genre'];
            $this->duration = $this->mySqliData['duration'];
            $this->path = $this->mySqliData['path'];
        }

        public function getId() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }
        
        public function getArtist() {
            return new Artist($this->con, $this->artistId);
        }

        public function getAlbum() {
            return new Album($this->con, $this->albumId);
        }

        public function getPath() {
            return $this->path;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getMySqliData() {
            return $this->mySqliData;
        }

        public function getGenre() {
            return $this->genre;
        }
    }
?>