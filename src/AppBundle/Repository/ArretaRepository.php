<?php

namespace AppBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;


/**
 * ArretaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArretaRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllFetched()
    {

        return $this->createQueryBuilder( 'a' )
                    ->leftJoin( 'a.user', 'u' )
                    ->addSelect( 'u' )
                    ->leftJoin( 'a.tramiteak', 't' )
                    ->addSelect( 't' )
                    ->leftJoin( 'u.barrutia', 'b' )
                    ->addSelect( 'b' )
                    ->getQuery()
                    ->getResult();

    }

    public function findMyAll( $id )
    {
        $em  = $this->getEntityManager();
        $sql = /** @lang text */
            "SELECT a
                FROM AppBundle:Arreta a
                INNER JOIN a.user u
                WHERE u.id = :id
                ORDER BY a.id DESC
        ";

        $consulta = $em->createQuery( $sql );
        $consulta->setParameter( 'id', $id );

        return $consulta->getResult();

    }

    public function bilatzailea( $hasi = null, $fin = null, $closed = null )
    {
        $em = $this->getEntityManager();


        $sql = /** @lang text */
            "
            SELECT a
                FROM AppBundle:Arreta a
                WHERE                 
        ";

        $where = "";
        if ( strlen( $hasi ) > 0 ) {
            $where = $where . "a.fetxa > :hasi ";
        }
        if ( strlen( $fin ) > 0 ) {
            if ( strlen( $where ) > 0 ) {
                $where = $where . " AND a.fetxa < :fin ";
            } else {
                $where = $where . "a.fetxa < :fin ";
            }
        }
        if ( strlen( $closed ) > 0 ) {
            if ( strlen( $where ) > 0 ) {
                $where = $where . "AND a.isclosed = :closed";
            } else {
                $where = $where . "a.isclosed = :closed";
            }
        }


        $consulta = $em->createQuery( $sql . $where );

        if ( strlen( $hasi ) > 0 ) {
            $consulta->setParameter( 'hasi', $hasi );
        }
        if ( strlen( $fin ) > 0 ) {
            $consulta->setParameter( 'fin', $fin );
        }
        if ( strlen( $closed ) > 0 ) {
            $consulta->setParameter( 'closed', $closed );
        }


        return $consulta->getResult();

    }

    public function findGaurkoArretaKopurua( $userid = null )
    {

        if ( isset( $userid ) ) {
            $em  = $this->getEntityManager();
            $d   = new \DateTime();
            $sql = /** @lang text */
                "
            SELECT count(a) as zenbat
                FROM AppBundle:Arreta a
                INNER JOIN a.user u
                WHERE a.fetxa > :date_start and a.fetxa < :date_end and u.id = :userid                 
            ";

            $consulta = $em->createQuery( $sql );
            $date     = new \DateTime();
            $consulta->setParameter( 'date_start', $date->format( 'Y-m-d 00:00:00' ) );
            $consulta->setParameter( 'date_end', $date->format( 'Y-m-d 23:59:59' ) );
            $consulta->setParameter( 'userid', $userid );

            return $consulta->getResult();
        } else {
            $em  = $this->getEntityManager();
            $d   = new \DateTime();
            $sql = /** @lang text */
                "
            SELECT count(a) as zenbat
                FROM AppBundle:Arreta a
                WHERE a.fetxa > :date_start and a.fetxa < :date_end                 
            ";

            /** @var Query $consulta */
            $consulta = $em->createQuery( $sql );
            $date     = new \DateTime();
            $consulta->setParameter( 'date_start', $date->format( 'Y-m-d 00:00:00' ) );
            $consulta->setParameter( 'date_end', $date->format( 'Y-m-d 23:59:59' ) );


            try {
                return $consulta->getSingleScalarResult();
            } catch ( NonUniqueResultException $e ) {
                return null;
            }
        }

    }

    public function findAllByFilterForm( $f )
    {

        /** @var QueryBuilder $query */
        $query = $this->createQueryBuilder( 'a' );

        $fecIni = date_format( $f[ 'fIni' ], 'Y-m-d' );
        $fecFin = date_format( $f[ 'fFin' ], 'Y-m-d');

        if ( !empty( $f[ 'fIni' ] ) ) {
            $query->andWhere( 'DATE(a.created) >= :fini' )
                  ->setParameter( 'fini', $fecIni );

        }
        if ( !empty( $f[ 'fFin' ] ) ) {
            $query->andWhere( 'DATE(a.created) <= :ffin' )
                  ->setParameter( 'ffin', $fecFin );
        }

        return $query->getQuery()->getResult();

    }

    public function findAllGroupByMonth($f=null) {

        /** @var QueryBuilder $query */
        $query = $this->createQueryBuilder('a' );
        $query->select( 'MONTH(a.created) as Hilabetea', 'COUNT(a.id) as Zenbat' );
        $query->groupBy( 'Hilabetea' );
        if ( !empty( $f[ 'fIni' ] ) ) {
            $query->andWhere( 'a.created >= :fini' )
                  ->setParameter( 'fini', $f[ 'fIni' ] );
        }
        if ( !empty( $f[ 'fFin' ] ) ) {
            $query->andWhere( 'a.created <= :ffin' )
                  ->setParameter( 'ffin', $f[ 'fFin' ] );
        }
        $query->andWhere( 'YEAR(a.created) = :urtea' );
        $query->setParameter( 'urtea', date( "Y" ) );


        return $query->getQuery()->getResult();
    }

    public function findAllPresentzialakGroupByMonth($f=null) {

        /** @var QueryBuilder $query */
        $query = $this->createQueryBuilder('a' );
        $query->select( 'MONTH(a.created) as Hilabetea', 'COUNT(a.id) as Zenbat' );
        $query->innerJoin( 'a.kanala', 'k' );
        $query->groupBy( 'Hilabetea' );
        $query->where( 'k.name LIKE :kanala' );
        $query->setParameter( 'kanala', 'Pres%' );
        if ( !empty( $f[ 'fIni' ] ) ) {
            $query->andWhere( 'a.created >= :fini' )
                  ->setParameter( 'fini', $f[ 'fIni' ] );
        }
        if ( !empty( $f[ 'fFin' ] ) ) {
            $query->andWhere( 'a.created <= :ffin' )
                  ->setParameter( 'ffin', $f[ 'fFin' ] );
        }
        $query->andWhere( 'YEAR(a.created) = :urtea' );
        $query->setParameter( 'urtea', date( "Y" ) );


        return $query->getQuery()->getResult();
    }

    public function findAllTelefonozGroupByMonth($f=null) {

        /** @var QueryBuilder $query */
        $query = $this->createQueryBuilder('a' );
        $query->select( 'MONTH(a.created) as Hilabetea', 'COUNT(a.id) as Zenbat' );
        $query->innerJoin( 'a.kanala', 'k' );
        $query->groupBy( 'Hilabetea' );
        $query->where( 'k.name LIKE :kanala' );
        $query->setParameter( 'kanala', 'Tele%' );
        if ( !empty( $f[ 'fIni' ] ) ) {
            $query->andWhere( 'a.created >= :fini' )
                  ->setParameter( 'fini', $f[ 'fIni' ] );
        }
        if ( !empty( $f[ 'fFin' ] ) ) {
            $query->andWhere( 'a.created <= :ffin' )
                  ->setParameter( 'ffin', $f[ 'fFin' ] );
        }
        $query->andWhere( 'YEAR(a.created) = :urtea' );
        $query->setParameter( 'urtea', date( "Y" ) );


        return $query->getQuery()->getResult();
    }

}
