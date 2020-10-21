<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    // requete title

    public function getAllBooksByTitle(string $title){
        $qb = $this->createQueryBuilder('b')
            ->where('b.title = :title')
            ->setParameter('title',$title);
        return $qb->getQuery()->execute();
    }

    // requete prix
    /**
     * @param int $price
     * @return int|mixed|string
     */
    public function getAllBooksCostingMoreThan(int $price){
        $query = $this->getEntityManager()->createQuery('
            SELECT b FROM App\Entity\Book AS b
            WHERE b.price > :price
        ');
        $query->setParameter('price',$price);
        return $query->getResult();
    }
    public function getAveragePriceByGenre(){
        $qb = $this->createQueryBuilder('b')
            ->join('b.genre','g')
            ->groupBy('g.id')
            ->select('g.name, AVG(b.price) as prix_moyen');
        return $qb->getQuery();
    }


    // requete genre
    public function getAllBooksByGenre(string $genre){
        $qb = $this->createQueryBuilder('b')
            ->join('b.genre','g')
            ->where('g.name = :genre')
            ->setParameter('genre', $genre);
        return $qb->getQuery()->execute();
    }

    public function getNbLineInRequestGenre(string $genre){
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->join('b.genre','g')
            ->where('g.name = :genre')
            ->setParameter('genre', $genre);
        return $qb->getQuery();
    }

    // requete editeur
    public function getAllBooksByPublisher(string $publisher){
        $qb = $this->createQueryBuilder('b')
            ->join('b.editeur','e')
            ->where('e.name = :publisher')
            ->setParameter('publisher', $publisher);
        return $qb->getQuery()->execute();
    }

    public function getNbLineInRequestEditeur(string $publisher){
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->join('b.editeur','e')
            ->where('e.name = :publisher')
            ->setParameter('publisher', $publisher);
        return $qb->getQuery();
    }

    // requète auteur
    public function getAllBooksByAuthor(string $author){
        $qb = $this->createQueryBuilder('b')
            ->join('b.auteur','a')
            ->where('a.name = :auteur')
            ->setParameter('auteur',$author);
        return $qb->getQuery()->execute();
    }

    public function getNbLineInRequestAuthor(string $author){
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(a.id) as nbAuthor')
            ->join('b.auteur','a')
            ->where('a.name = :auteur')
            ->setParameter('auteur',$author);
        return $qb->getQuery();
    }

    //requete date
    public function getAllDateOfPublication(){
        $pdo = $this->getEntityManager()->getConnection();
        $sql = "SELECT DISTINCT YEAR (published_at) as year FROM book GROUP BY published_at";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAllAssociative();
    }
    public function getAllBooksByDate(string $date){
        $qb = $this->createQueryBuilder('b')
            ->where('YEAR(b.publishedAt) = :date')
            ->setParameter('date',$date);
        return $qb->getQuery()->execute();
    }

    public function getNbLineInRequestDate(string $date){
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(b.id) as nbDate')
            ->where('YEAR(b.publishedAt) = :date')
            ->setParameter('date',$date);
        return $qb->getQuery();
    }

    //requete livre
    public function getTotalNumberOfBooks(){
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(b.id) as nb');
        return $qb->getQuery();
    }



    //requete exemple
    public function getAllWithQueryBuilder(){
        $qb = $this->createQueryBuilder('b')
            ->orderBy('b.publishedAt')
            ->setMaxResults(10);
        return $qb->getQuery();
    }

    public function getAllWithDQL(){
        $query = $this->getEntityManager()->createQuery(
            'SELECT b.id,b.title,b.price, g.name 
                FROM App\Entity\Book AS b 
                JOIN b.genre as g 
                ORDER BY b.publishedAt'
        )->setMaxResults(10);
        return $query;
    }

    public function getAllWithSQL(){
        $pdo = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM book ORDER BY published_at LIMIT 10";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAllAssociative();
    }
}
