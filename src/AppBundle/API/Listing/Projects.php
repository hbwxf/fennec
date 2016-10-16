<?php

namespace AppBundle\API\Listing;

use AppBundle\API\Webservice;
use \PDO as PDO;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Web Service.
 * Returns information of all users projects
 */
class Projects extends Webservice
{
    /**
    * @inheritdoc
    * @returns Array $result
    * <code>
    * array(array('project_id','import_date','OTUs','sample size'));
    * </code>
    */
    public function execute(ParameterBag $query, SessionInterface $session = null)
    {
        $db = $this->getDbFromQuery($query);
        $result = array('data' => array());
        if (!$session->isStarted() || !$session->has('user')) {
            $result['error'] = Webservice::ERROR_NOT_LOGGED_IN;
        } else {
            $query_get_user_projects = <<<EOF
SELECT
    webuser_data_id,
    import_date,project->>'id' AS id,
    project->'shape'->>0 AS rows,
    project->'shape'->>1 AS columns,
    import_filename
    FROM full_webuser_data WHERE provider = :provider AND oauth_id = :oauth_id
EOF;
            $stm_get_user_projects = $db->prepare($query_get_user_projects);
            $stm_get_user_projects->bindValue('provider', $session->get('user')['provider']);
            $stm_get_user_projects->bindValue('oauth_id', $session->get('user')['id']);
            $stm_get_user_projects->execute();
        
            while ($row = $stm_get_user_projects->fetch(PDO::FETCH_ASSOC)) {
                $project = array();
                $project['internal_project_id'] = $row['webuser_data_id'];
                $project['id'] = $row['id'];
                $project['import_date'] = $row['import_date'];
                $project['rows'] = $row['rows'];
                $project['columns'] = $row['columns'];
                $project['import_filename'] = $row['import_filename'];
                $result['data'][] = $project;
            }
        }
        return $result;
    }
}
