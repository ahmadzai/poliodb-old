<?php

namespace App\PolioDbBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TempCatchupDataRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TempCatchupDataRepository extends EntityRepository
{
  public function catchupSyncToMaster()
  {

    $sql = "
    INSERT INTO catchup_data(district_code, campaign_id, cluster_name, cluster_no, reg_absent, vacc_absent, reg_sleep, vacc_sleep, reg_refusal,
    vacc_refusal, new_missed, new_vaccinated) SELECT districtCode, campaignId, clusterName, clusterNo, regAbsent, vaccAbsent, regSleep, vaccSleep,
    regRefusal, vaccRefusal, newMissed, newVaccinated FROM temp_catchup_data
    ";

    $em = $this->getEntityManager();
    return $em->getConnection()->query($sql);
  }

  public function truncatTempCatchupData()
  {

     $sql = "TRUNCATE temp_catchup_data";

    $em = $this->getEntityManager();
    return $em->getConnection()->query($sql);
  }
}