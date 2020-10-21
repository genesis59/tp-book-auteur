<?php


namespace App\DataFixtures;


class ReferencesRepository
{
    /**
     * @var array
     */
    private $authorList = ["Arfi","Hugo","Auster","Dickinson"];

    /**
     * @var array
     */
    private $auteurList = ["bueno","caramel","trififi"];

    /**
     * @var array
     */
    private $genreList = ["Roman","Informatique","Poésie","Essai","Philo","Economie"];

    /**
     * @var array
     */
    private $publisherList = ["Hachette","Grasset","Peachit Press","O' reilly", "PUF"];

    /**
     * @var array
     */
    private $tagList = ["Informatique","Humour","Symfony","PHP","Fashion","Téléphonie"];

    /**
     * @return array
     */
    public function getAuthorList(): array
    {
        return $this->authorList;
    }

    /**
     * @param array $authorList
     */
    public function setAuthorList(array $authorList): void
    {
        $this->authorList = $authorList;
    }

    /**
     * @return array
     */
    public function getGenreList(): array
    {
        return $this->genreList;
    }

    /**
     * @param array $genreList
     */
    public function setGenreList(array $genreList): void
    {
        $this->genreList = $genreList;
    }

    /**
     * @return array
     */
    public function getPublisherList(): array
    {
        return $this->publisherList;
    }

    /**
     * @param array $publisherList
     */
    public function setPublisherList(array $publisherList): void
    {
        $this->publisherList = $publisherList;
    }

    /**
     * @return array
     */
    public function getTagList(): array
    {
        return $this->tagList;
    }

    /**
     * @param array $tagList
     */
    public function setTagList(array $tagList): void
    {
        $this->tagList = $tagList;
    }
    /**
     * @return array
     */
    public function getAuteurList(): array
    {
        return $this->auteurList;
    }


    /**
     * @param array $auteurList
     */
    public function setAuteurList(array $auteurList): void
    {
        $this->auteurList = $auteurList;
    }

    private function pickOne($collection){
        return $collection[array_rand($collection)];
    }

    public function getRandomAuteur(){
        return $this->pickOne($this->auteurList);
    }

    public function getRandomPublisher(){
        return $this->pickOne($this->publisherList);
    }

    public function getRandomTag(){
        return "tag_".$this->pickOne($this->tagList);
    }

    public function getRandomGenre(){
        return $this->pickOne($this->genreList);
    }

}