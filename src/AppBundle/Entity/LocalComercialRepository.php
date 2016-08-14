<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LocalComercialRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LocalComercialRepository extends EntityRepository {

    /**
     * @param type $array
     * @return boolean
     */
    public function ordenarPorDistanciaALocal($array) {
        return uasort($array, function(LocalComercial $a, LocalComercial $b) {
            return $a->compareTo($b);
        }
        );
    }

    /**
     * Retorna una lista con los locales que tiene cupones que no han sido cobrado aun
     */
    public function getPendientesCobro() {
        $query = $this->getEntityManager()
                ->createQuery(
                        "select loc.id, loc.nombre, loc.nombreContacto, loc.emailContacto, loc.telefonoContacto
                from AppBundle:Cupon cup
                     join cup.programacion prog
                     join prog.promocion prom
                     join prom.localComercial loc
                     join cup.estadoCobroCupon estCobro
                     join cup.estadoCupon est
                     join cup.tipoCupon tipoC
                where estCobro.nombre=:paramEstadoCobroCupon
                    and tipoC.nombre=:paramTipoCupon and est.nombre=:paramEstadoCupon
                     GROUP BY loc.id, loc.nombre, loc.nombreContacto, loc.emailContacto, loc.telefonoContacto ")
                ->setParameter('paramEstadoCobroCupon', 'pendiente')
                ->setParameter('paramTipoCupon', 'promocion')
                ->setParameter('paramEstadoCupon', 'canjeado');

        //echo $query->getSQL();exit;
        return $query->getResult();
    }

    /**
     * Retorna una lista con los locales que tiene cobros 
     */
    public function getCobrados() {
        $query = $this->getEntityManager()
                ->createQuery(
                        "select loc.id, loc.nombre, loc.nombreContacto, loc.emailContacto, loc.telefonoContacto
                from AppBundle:Cupon cup
                     join cup.programacion prog
                     join prog.promocion prom
                     join prom.localComercial loc
                     join cup.estadoCobroCupon estCobro
                     join cup.estadoCupon est
                     join cup.tipoCupon tipoC
                where estCobro.nombre=:paramEstadoCobroCupon
                    and tipoC.nombre=:paramTipoCupon and est.nombre=:paramEstadoCupon
                GROUP BY loc.id, loc.nombre, loc.nombreContacto, loc.emailContacto, loc.telefonoContacto")
                ->setParameter('paramEstadoCobroCupon', 'cobrado')
                ->setParameter('paramTipoCupon', 'promocion')
                ->setParameter('paramEstadoCupon', 'canjeado');

        //echo $query->getSQL();exit;
        return $query->getResult();
    }

    public function getItemsPendientesCobro($idLocal) {
        $query = $this->getEntityManager()
                ->createQuery(
                        "select cup.id,loc.id as idLocal, loc.nombre, cup.fecha, prom.titulo, cup.precioCobroLocal, cup.codigo
                from AppBundle:Cupon cup
                     join cup.programacion prog
                     join prog.promocion prom
                     join prom.localComercial loc
                     join cup.estadoCobroCupon estCobro
                     join cup.estadoCupon est
                     join cup.tipoCupon tipoC
                where estCobro.nombre=:paramEstadoCobroCupon
                    and tipoC.nombre=:paramTipoCupon and est.nombre=:paramEstadoCupon
                    and loc.id=:paramIdLocal 
                    ORDER BY cup.fecha ASC")
                ->setParameter('paramEstadoCobroCupon', 'pendiente')
                ->setParameter('paramTipoCupon', 'promocion')
                ->setParameter('paramEstadoCupon', 'canjeado')
                ->setParameter('paramIdLocal', $idLocal);

        //echo $query->getSQL();exit;
        return $query->getResult();
    }

    public function getItemsCobradosCobro($idLocal) {
        $query = $this->getEntityManager()
                ->createQuery(
                        "select cup.id,loc.id as idLocal, loc.nombre, cup.fecha, prom.titulo, prom.precio*:paramPorcCobro as precio
                from AppBundle:Cupon cup
                     join cup.programacion prog
                     join prog.promocion prom
                     join prom.localComercial loc
                     join cup.estadoCobroCupon estCobro
                     join cup.estadoCupon est
                     join cup.tipoCupon tipoC
                where estCobro.nombre=:paramEstadoCobroCupon
                    and tipoC.nombre=:paramTipoCupon and est.nombre=:paramEstadoCupon
                    and loc.id=:paramIdLocal 
                    ORDER BY cup.fecha ASC")
                ->setParameter('paramEstadoCobroCupon', 'cobrado')
                ->setParameter('paramTipoCupon', 'promocion')
                ->setParameter('paramEstadoCupon', 'canjeado')
                ->setParameter('paramPorcCobro', 0.20)
                ->setParameter('paramIdLocal', $idLocal);

        //echo $query->getSQL();exit;
        return $query->getResult();
    }

}
