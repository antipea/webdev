<?php

declare(strict_types=1);

class GeneralHandler

{
public function setStatistics(Template &$template_object): void
{
    $db_handle = new DB();
    $query = "Select * from `members` where member_name = ?";
    $result = $db_handle->runQuery($query, 's', array($username));
    return $result;

$mysql = MySQL::getInstance();

$r = $mysql->executeQuery("SELECT COUNT(*) AS `total_users` FROM `user`");
$row_one = $r['stmt']->fetch(PDO::FETCH_ASSOC);
$template_object->setPlaceholder('statistics_users', $row_one['total_users']);

$r = $mysql->executeQuery("SELECT SUM(`sf_size`) AS `total_size`, COUNT(*) AS `total_files` FROM `stored_file`");
$row_two = $r['stmt']->fetch(PDO::FETCH_ASSOC);
$total_volume = round($row_two['total_size'] / 1048576, 2);

$template_object->setPlaceholder('statistics_volume', (string)$total_volume);
$template_object->setPlaceholder('statistics_files', (string)$row_two['total_files']);
$template_object->setPlaceholder('statistics_volume_per_user', (string)round($total_volume / $row_one['total_users'], 2));
}

public function setAllowedFileTypesAndUsage(Template $template_object, string $list_item, array &$user): void
{
$result = '';
$list_item = file_get_contents($list_item);

$mysql = MySQL::getInstance();

$r = $mysql->executeQuery("SELECT * FROM `allowed_file` WHERE `af_user`=:user_id", array(array(':user_id', $user['u_id'], 'integer')));
while ($row = $r['stmt']->fetch(PDO::FETCH_ASSOC)) {
$copy = $list_item;
$copy = str_replace('{EXTENSION}', $row['af_extension'], $copy);
$copy = str_replace('{SIZE}', $row['af_limit'], $copy);
$result .= $copy;
}
$template_object->setPlaceholder('allowed_file_types', $result);
$template_object->setPlaceholder('allowed_to_user', (string)$user['u_limit']);

$r = $mysql->executeQuery("SELECT SUM(`sf_size`) AS `ts` FROM `stored_file` WHERE `sf_user`=:user_id", array(array(':user_id', $user['u_id'], 'integer')));
$used_by_user = $r['stmt']->fetch(PDO::FETCH_ASSOC)['ts'];
$template_object->setPlaceholder('used_by_user', (string)round($used_by_user / 1048576, 2));
$user['homedir_real_size'] = $used_by_user;
}

public function setUserDirContents(Template &$template_object, string $list_item, array $user, string $root_folder): void
{
$result = '';
$list_item = file_get_contents($list_item);

$mysql = MySQL::getInstance();

$r = $mysql->executeQuery("SELECT * FROM `stored_file` WHERE `sf_user`=:user_id", array(array(':user_id', $user['u_id'], 'integer')));
while ($row = $r['stmt']->fetch(PDO::FETCH_ASSOC)) {

$ffn = $root_folder . '/' . $user['u_homedir'] . '/' . $row['sf_store_name'];
if (!is_file($ffn)) {
continue;
}

$copy = $list_item;
$copy = str_replace('{FILE_ID}', $row['sf_id'], $copy);
$copy = str_replace('{FILE_NAME}', $row['sf_source_name'], $copy);
$copy = str_replace('{FILE_SIZE}', round($row['sf_size'] / 1024, 2), $copy);
$copy = str_replace('{FILE_DT}', date('Y.m.d H:i:s', (int)$row['sf_dt']), $copy);
$result .= $copy;
}
$template_object->setPlaceholder('stored_files', $result);
}
}