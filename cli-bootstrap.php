<?php
use API\Models\Entity\Users\User;
use API\Models\Entity\Users\UserAttribute;
use API\Models\Entity\Users\UserGroup;
use API\Models\Entity\Users\UserPermission;
use API\Models\Entity\Users\UserRole;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use HYKY\Api;

/**
 * Services : CLI Bootstrap
 * ----------------------------------------------------------------------
 * Bootstraps all your basic data needs.
 *
 * Registers some basic data you can use to test the API, like user groups,
 * permissions and roles.
 *
 * Also, initializes the super administrator account.
 *
 * @author      HYKY team <we@hyky.games>
 * @copyright   2018 HYKY team
 * @since       0.0.1
 */

// Require Composer autoload
require_once('vendor/autoload.php');

// Fire application, get container
$container = (new Api())->getContainer();

// Set entity manager
/** @var EntityManager $em */
$em = $container->get('em');

/** @var QueryBuilder $qb */
$qb = $em->createQueryBuilder();

// Create a slugify instance
$slugify = new Slugify();

// Load bootstrapper data
$list = [
    'groups' => json_decode(
        file_get_contents(API_DATA_DIR."\\bootstrap\\user.groups.json"),
        true
    ),
    'permissions' => json_decode(
        file_get_contents(API_DATA_DIR."\\bootstrap\\user.permissions.json"),
        true
    ),
    'roles' => json_decode(
        file_get_contents(API_DATA_DIR."\\bootstrap\\user.roles.json"),
        true
    ),
    'users' => json_decode(
        file_get_contents(API_DATA_DIR."\\bootstrap\\user.users.json"),
        true
    )
];

// Flags to stop/skip if data has been loaded
$has_data = [
    'groups' => $em
        ->getRepository("API\Models\Entity\Users\UserGroup")
        ->findAll(),
    'permissions' => $em
        ->getRepository("API\Models\Entity\Users\UserPermission")
        ->findAll(),
    'roles' => $em
        ->getRepository("API\Models\Entity\Users\UserRole")
        ->findAll(),
    'users' => $em
        ->getRepository("API\Models\Entity\Users\User")
        ->findAll()
];

// Temporary stores so we don't keep querying stuff
$stores = [
    'roles' => [],
    'permissions' => [],
    'groups' => []
];

// Groups
// ----------------------------------------------------------------------

// Checks if groups have been intiialized
if (count($has_data['groups']) > 0) {
    // Log message
    print "\r\n";
    print "\x1b[1m\x1b[31m-- GROUPS ALREADY INITIALIZED!\x1b[0m\r\n";
} else {
    // Add groups
    foreach ($list['groups'] as $group) {
        $user_group = (new UserGroup())
            ->setName($group['name'])
            ->setSlug($slugify->slugify($group['slug']))
            ->setDescription($group['description'])
            ->setImage($group['image'])
            ->setIsPublic($group['is_public'])
            ->setIsProtected($group['is_protected']);
        // Persist group
        $em->persist($user_group);
    
        // Add group to store
        if (!isset($stores['groups'][$group['name']])) {
            $stores['groups'][$group['name']] = $user_group;
        }
    }
}

// Flush data
$em->flush();

// Permissions
// ----------------------------------------------------------------------

// Checks if permissions have been intiialized
if (count($has_data['permissions']) > 0) {
    // Log message
    print "\r\n";
    print "\x1b[1m\x1b[31m-- PERMISSIONS ALREADY INITIALIZED!\x1b[0m\r\n";
} else {
    // Add permissions
    foreach ($list['permissions'] as $permission) {
        $user_permission = (new UserPermission())
            ->setName($permission['name'])
            ->setSlug($slugify->slugify($permission['slug']));
        // Persist permission
        $em->persist($user_permission);
    
        // Add permission to store
        if (!isset($stores['permissions'][$permission['name']])) {
            $stores['permissions'][$permission['name']] = $user_permission;
        }
    }
}

// Flush data
$em->flush();

// Roles
// ----------------------------------------------------------------------

// Checks if roles have been intiialized
if (count($has_data['roles']) > 0) {
    // Log message
    print "\r\n";
    print "\x1b[1m\x1b[31m-- ROLES ALREADY INITIALIZED!\x1b[0m\r\n";
} else {
    // Add roles
    foreach ($list['roles'] as $role) {
        $user_role = (new UserRole())
            ->setName($role['name'])
            ->setSlug($slugify->slugify($role['slug']))
            ->setDescription('');
        
        // Assign permissions
        foreach ($role['permissions'] as $permission_name) {
            if (isset($stores['permissions'][$permission_name])) {
                // Get permission from store
                $user_role->addPermission(
                    $stores['permissions'][$permission_name]
                );
            } else {
                // Search for permission
                $role_permission = $em
                    ->getRepository("API\Models\Entity\Users\UserPermission")
                    ->findOneBy([
                        'name' => $permission_name
                    ]);
                // Assign if exists
                if ($role_permission !== false && $role_permission !== null) {
                    $user_role->addPermission($role_permission);
                }
            }
        }
        
        // Persist role
        $em->persist($user_role);
    
        // Add role to store
        if (!isset($stores['roles'][$role['name']])) {
            $stores['roles'][$role['name']] = $user_role;
        }
    }
}

// Flush data
$em->flush();

// Users
// ----------------------------------------------------------------------

// Checks if users have been intiialized
if (count($has_data['users']) > 0) {
    // Log message
    print "\r\n";
    print "\x1b[1m\x1b[31m-- USERS ALREADY INITIALIZED!\x1b[0m\r\n";
} else {
    // Add users
    foreach ($list['users'] as $user) {
        $new_user = (new User())
            ->setUsername($user['username'])
            ->setPassword($user['password'])
            ->setEmail($user['email'])
            ->setIsPublic(false);
        
        // Get and assign user role
        if (isset($stores['roles'][$user['role']])) {
            $role = $stores['roles'][$user['role']];
        } else {
            $role = $em
                ->getRepository("API\Models\Entity\Users\UserRole")
                ->findOneBy([
                    'name' => $user['role']
                ]);
        }
        
        if (isset($role) && $role !== null && $role !== false) {
            $new_user->setRole($role);
        }
        
        // Assign groups
        foreach ($user['groups'] as $group_name) {
            // Checks store
            if (isset($stores['groups'][$group_name])) {
                $group = $stores['groups'][$group_name];
            } else {
                $group = $em
                    ->getRepository("API\Models\Entity\Users\UserGroup")
                    ->findOneBy([
                        'name' => $group_name
                    ]);
            }
            
            // If group exists and is valid, assign
            if (isset($group) && $group !== null && $group !== false) {
                $new_user->addGroup($group);
            }
        }
        
        // Persist role
        $em->persist($new_user);
    
        // Assign attributes
        foreach ($user['attributes'] as $key => $value) {
            // Create attribute
            $attr = (new UserAttribute())
                ->setName($key)
                ->setValue($value)
                ->setUser($new_user);
            
            // Persist attribute
            $em->persist($attr);
        }
    }
}

// Flush
$em->flush();

// Finished, now GTFO!
// ----------------------------------------------------------------------

// Print data
print "\r\n";
print "\x1b[1m\x1b[31m-- FINISHED INITIALIZING DATA\x1b[0m\r\n";
print "\x1b[1m\x1b[33m-- --------------------------------------------------\x1b[0m\r\n";
print "-- All right! Now you're good to go!\r\n";
print "-- \r\n";
print "-- Try authenticating into the '/api/auth' endpoint and use\r\n";
print "-- the returned token to validate a request.\r\n";
print "-- \r\n";
print "-- If it's working correctly, then GET WORKING!\r\n";
print "\x1b[1m\x1b[33m-- --------------------------------------------------\x1b[0m\r\n";
return true;
