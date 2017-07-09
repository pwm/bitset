<?php
declare(strict_types=1);

require_once __DIR__.'/Group.php';
require_once __DIR__.'/User.php';

$user = new User();
assert($user->getGroups() === []);
assert($user->hasGroup(Group::G2) === false);

$user->setGroups([Group::G1, Group::G2]);
assert($user->getGroups() === [Group::G1, Group::G2]);
assert($user->hasGroup(Group::G2) === true);

$user->addGroups([Group::G4, Group::G5]);
assert($user->getGroups() === [Group::G1, Group::G2, Group::G4, Group::G5]);
assert($user->hasGroup(Group::G2) === true);
assert($user->hasGroup(Group::G4) === true);

$user->removeGroups([Group::G1, Group::G4]);
assert($user->getGroups() === [Group::G2, Group::G5]);
assert($user->hasGroup(Group::G2) === true);
assert($user->hasGroup(Group::G4) === false);
