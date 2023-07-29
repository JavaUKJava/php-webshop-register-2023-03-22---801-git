<?php

$rootPath = __DIR__;
$rootPath = str_replace('user' . DIRECTORY_SEPARATOR . 'controller', '', $rootPath);
require_once $rootPath . 'base/importRequireFileList.php';
importRequireFileList(__FILE__ . '/');

if (isset($_GET)) {
    if (isset($_GET['showRegisterUserViewSubmitButton'])) {
        showRegisterUserView();
    } else if (isset($_GET['showLoginUserViewSubmitButton'])) {
        showLoginUserView();
    } else if (isset($_GET['logoutUserSubmitButton'])) {
        logoutUser();
    } else if (isset($_GET['showAllUsersViewSubmitButton'])) {
        showAllUsersView();
    } else if (isset($_GET['showEditUserViewSubmitButton'])) {
        showEditUserView();
    } else if (isset($_GET['deleteUserSubmitButton'])) {
        deleteUser();
    } else if (isset($_GET['showEditOwnUserViewSubmitButton'])) {
        showEditOwnUserView();
    }
}

if (isset($_POST)) {
    if (isset($_POST['registerUserSubmitButton'])) {
        registerUser();
    } else if (isset($_POST['loginUserSubmitButton'])) {
        loginUser();
    } else if (isset($_POST['deleteUserLastLoginTimeSubmitButton'])) {
        deleteUserLastLoginTime();
    } else if (isset($_POST['createUserSubmitButton'])) {
        createUser();
    } else if (isset($_POST['editOwnUserSubmitButton'])) {
        editOwnUser();
    }
}

function createNotRegisteredUser()
{
    global $userService;

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $loginName = microtime();
    $createSuccess = $userService->createNotRegisteredUser($loginName);

    if ($createSuccess == true) {
        // load the new user again, because he need the id in it
        $loadedUser = $userService->getUserByLoginName($loginName);
        $loggedInUserData = $userService->getLoggedInUserDataFromUser($loadedUser);
        $_SESSION['loggedInUserData'] = $loggedInUserData;
    }

    header("Location: index.php");
    exit();
}

function showRegisterUserView()
{
    if (isset($_GET) && isset($_GET['showRegisterUserViewSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $salutations = $userService->getSalutations();
        $_SESSION['salutations'] = $salutations;

        header('Location: ../view/registerUserView.php');
        exit();
    }
}

function registerUser()
{
    $userService = new UserService();

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_POST) && isset($_POST['registerUserSubmitButton'])) {
        $loginName = htmlspecialchars($_POST['loginName']);
        $salutationId = htmlspecialchars($_POST['salutationId']);
        $titleBeforeName = htmlspecialchars($_POST['titleBeforeName']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $titleAfterName = htmlspecialchars($_POST['titleAfterName']);
        $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $passwordRepeat = htmlspecialchars($_POST['passwordRepeat']);

        // create transport data box
        $createUserData = new CreateUserData($loginName, $salutationId, $titleBeforeName, $firstName, $lastName, $titleAfterName, $phoneNumber, $email, $password, $passwordRepeat);

        $errorMessage = $userService->testInputsForCreateUser($createUserData);

        if ($errorMessage != null) {
            $salutations = $userService->getSalutations();
            $_SESSION['salutations'] = $salutations;
    
            // return transport data box to session (without password and password repeat)
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['createUserData'] = $createUserData;

            header("Location: ../view/registerUserView.php");
            exit();
        } else {
            // save user in database
            $salutation = $userService->getSalutationById($createUserData->getSalutationId());
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $roleName = "STANDARD_USER";
            $role = $userService->getRoleByName($roleName);
            $roles = array();
            array_push($roles, $role);

            $user = new User(null, $createUserData->getLoginName(), $salutation, $createUserData->getTitleBeforeName(), $createUserData->getFirstName(), $createUserData->getLastName(),
                                $createUserData->getTitleAfterName(), $createUserData->getPhoneNumber(), $createUserData->getEmail(), null, $hashedPassword, time(), time(), true, $roles);

            $createSuccess = $userService->saveUser($user);

            if ($createSuccess == true) {
                loginUserDetail($loginName, $password);
                exit();
            } else {
                header("Location: ../view/registerUserView.php?error=sqlerror");
                exit();
            }
        }
    }
}

function showLoginUserView()
{
    if (isset($_GET) && isset($_GET['showLoginUserViewSubmitButton'])) {
        header('Location: ../view/loginUserView.php');
        exit();
    }
}

function loginUser()
{
    if (isset($_POST) && isset($_POST['loginUserSubmitButton'])) {
        $loginName = htmlspecialchars($_POST['loginName']);
        $password = htmlspecialchars($_POST['password']);

        if (empty($loginName) || empty($password)) {
            header("Location: ../view/loginUserView.php?error=emptyField&loginName=" . $loginName);
            exit();
        } else {
            loginUserDetail($loginName, $password);
            exit();
        }
    }
}

function loginUserDetail($loginName, $password)
{
    $userService = new UserService();
    $cartService = new CartService();

    if (isset($_POST) && (isset($_POST['registerUserSubmitButton']) || isset($_POST['loginUserSubmitButton']))) {
        // look in database for exist loginName
        $user = $userService->getUserByLoginName($loginName);

        if (isset($user)) {
            $passwordCheck = password_verify($password, $user->getPassword());

            if ($passwordCheck == false) {
                header("Location: ../view/loginUserView.php?error=wrongLoginNameOrPassword");
                exit();
            } else if ($passwordCheck == true) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }

                $currentLoggedInUserData = $_SESSION['loggedInUserData'];
                $currentUserId = $currentLoggedInUserData->getId();
                $currentUser = $userService->getUserById($currentUserId);

                if ($currentUser->isRole('NOT_REGISTERED_USER')) {
                    // for all cartEntry from currentUser set the user id from the loggend in user
                    $currentUserCartEntrys = $cartService->getCartEntrysByUserId($currentUserId);

                    foreach ($currentUserCartEntrys as $cartEntry) {
                        $cartService->addProductToCart($user->getId(), $cartEntry->getProduct()->getId(), $cartEntry->getProductCount());
                        $cartService->removeProductFromCart($cartEntry);
                    }

                    // delte currentUser because he is a NOT_REGISTERED_USER
                    $userService->deleteUser($currentUserId);

                    // insert new last login time for the user who login
                    $userService->saveLastLoginTimeForUser($user, time());

                    $newLoggedInUserData = $userService->getLoggedInUserDataFromUser($user);
                    $_SESSION['loggedInUserData'] = $newLoggedInUserData;

                    header('Location: ../../index.php?info=loginSuccess');
                    exit();
                } else {
                    header("Location: ../view/loginUserView.php?error=anyUserIsStillLoggedIn");
                    exit();
                }
            } else {
                header("Location: ../view/loginUserView.php?error=wrongLoginNameOrPassword");
                exit();
            }
        } else {
            header("Location: ../view/loginUserView.php?error=wrongLoginNameOrPassword");
            exit();
        }
    }
}

function logoutUser()
{
    if (isset($_GET) && isset($_GET['logoutUserSubmitButton'])) {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
    }
}

function showAllUsersView()
{
    if (isset($_GET) && isset($_GET['showAllUsersViewSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_SHOW')) {
            unset($_SESSION['users']);
            header("Location: ../view/showAllUsersView.php?error=notAllowed");
            exit();
        } else {
            $users = $userService->getUsers();

            if ($users == null) {
                header("Location: ../view/showAllUsersView.php?info=noUserAvailable");
                exit();
            } else {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    header("Location: ../view/showAllUsersView.php?error=noSessionAvailable");
                    exit();
                } else {
                    $_SESSION['users'] = $users;

                    header("Location: ../view/showAllUsersView.php?");
                    exit();
                }
            }
        }
    }
}

function showEditUserView()
{
    if (isset($_GET) && isset($_GET['showEditUserViewSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_EDIT')) {
            header("Location: ../view/showAllUsersView.php?error=notAllowed");
            exit();
        } else {
            if (isset($_GET['id'])) {
                $userId = htmlspecialchars($_GET['id']);
                $user = $userService->getUserById($userId);
                $roles = $userService->getRoles();

                if (isset($user)) {
                    $_SESSION['user'] = $user;
                    $_SESSION['roles'] = $roles;
                    header("Location: ../view/createEditUserView.php");
                    exit();
                }
            }
        }
    }
}

function showEditOwnUserView()
{
    if (isset($_GET) && isset($_GET['showEditOwnUserViewSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_EDIT_OWN')) {
            header("Location: ../../index.php?error=notAllowed");
            exit();
        } else {
            $editOwnUserData = $userService->getEditOwnUserDataFromUser($loggedInUser);

            if (isset($editOwnUserData)) {
                $_SESSION['editOwnUserData'] = $editOwnUserData;
                header("Location: ../view/createEditOwnUserView.php");
                exit();
            }
        }
    }
}

function createUser()
{
    if (isset($_POST) && isset($_POST['createUserSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_CREATE|USER_EDIT')) {
            header("Location: ../view/createEditProductView.php?error=notAllowed");
            exit();
        } else {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (isset($_POST['id']) && htmlspecialchars($_POST['id']) > 0) {
                $id = htmlspecialchars($_POST['id']);
            } else {
                $id = null;
            }

            $loginName = htmlspecialchars($_POST['loginName']);
            $oldPassword = null;

            if ($id != null) {
                $oldPassword = htmlspecialchars($_POST['oldPassword']);
            }

            $newPassword = htmlspecialchars($_POST['newPassword']);
            $newPasswordRepeat = htmlspecialchars($_POST['newPasswordRepeat']);
            $newRolesNameArray = ($_POST['newRoles']);

            if (isset($_POST['active'])) {
                $active = 1;
            } else {
                $active = 0;
            }

            // test user data
            $errorMessage = null;

            if ($id == null) {
                $errorMessage = $userService->testInputsForCreateUser($loginName, $newPassword, $newPasswordRepeat);
            } else {
                $errorMessage = $userService->testInputsForEditUser($id, $loginName, $oldPassword, $newPassword, $newPasswordRepeat);
            }

            if ($errorMessage != null) {
                $roles = array();

                foreach ($newRolesNameArray as $roleName) {
                    $role = $userService->getRoleByName($roleName);
                    array_push($roles, $role);
                }

                $user = $userService->getUserById($id);
                $user->setLoginName($loginName);
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
                $user->setActive($active);
                $user->setRoles($roles);

                $_SESSION['user'] = $user;
                $allRoles = $userService->getRoles();
                $_SESSION['roles'] = $allRoles;
                header("Location: ../view/createEditUserView.php?error=" . $errorMessage);
                exit();
            }

            // begin create user
            $roles = array();

            foreach ($newRolesNameArray as $roleName) {
                $role = $userService->getRoleByName($roleName);
                array_push($roles, $role);
            }

            $user = null;
            $savedUser = null;

            if ($id == null) {
                // create new user
                echo '<script>alert("Not implemented to create a user on this way! Use Register user!")</script>';
            } else {
                // edit exist user
                $user = $userService->getUserById($id);
                $user->setLoginName($loginName);

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
                $user->setActive($active);
                $user->setRoles($roles);

                $savedUser = $userService->saveUser($user);
            }

            if (isset($savedUser)) {
                $_SESSION['user'] = $user;
                header("Location: ../view/createEditUserView.php?info=addedSuccess");
                exit();
            } else {
                $_SESSION['user'] = $user;
                header("Location: ../view/createEditUserView.php?error=faildToSave");
                exit();
            }
        }
    }
}

function editOwnUser()
{
    if (isset($_POST) && isset($_POST['editOwnUserSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_EDIT_OWN')) {
            header("Location: ../../index.php.php?error=notAllowed");
            exit();
        } else {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $id = -1;

            if (isset($_POST['id']) && htmlspecialchars($_POST['id']) > 0) {
                $id = htmlspecialchars($_POST['id']);
            }

            if ($id <= 0 || $id != $loggedInUserId) {
                // loggedInUser could only edit his one account
                header("Location: ../../index.php.php?error=notAllowed");
                exit();
            } else {
                $loginName = htmlspecialchars($_POST['loginName']);
                $oldPassword = htmlspecialchars($_POST['oldPassword']);;
                $newPassword = htmlspecialchars($_POST['newPassword']);
                $newPasswordRepeat = htmlspecialchars($_POST['newPasswordRepeat']);

                // test user data
                $errorMessage = $userService->testInputsForEditOwnUser($id, $loginName, $oldPassword, $newPassword, $newPasswordRepeat);

                if ($errorMessage != null) {
                    $editOwnUserData = $userService->getEditOwnUserDataFromUser($loggedInUser);

                    if (isset($editOwnUserData)) {
                        $_SESSION['editOwnUserData'] = $editOwnUserData;
                        header("Location: ../view/createEditOwnUserView.php?error=" . $errorMessage);
                        exit();
                    }
                }

                // edit exist user
                $user = $loggedInUser;
                $user->setLoginName($loginName);
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);

                $savedUser = $userService->saveUser($user);

                if (isset($savedUser)) {
                    header("Location: ../../index.php?info=editOwnUserSuccess");
                    exit();
                } else {
                    header("Location: ../../index.php?error=faildToSave");
                    exit();
                }
            }
        }
    }
}

function deleteUser()
{
    if (isset($_GET) && isset($_GET['deleteUserSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_DELETE')) {
            header("Location: ../view/showAllUsersView.php?error=notAllowed");
            exit();
        } else {
            if (isset($_GET['id']) && htmlspecialchars($_GET['id']) > 0) {
                $id = htmlspecialchars($_GET['id']);

                if (empty($id) || $id <= 0) {
                    header("Location: ../view/showAllUsersView.php?error=deleteUserNotFound");
                    exit();
                } else {

                    // delete cartEntry from user before delete user

                    $deleteSuccess = $userService->deleteUser($id);
                    $users = $userService->getUsers();
                    session_start();
                    $_SESSION['users'] = $users;

                    if ($deleteSuccess == true) {
                        header("Location: ../view/showAllUsersView.php?info=deleteSuccess");
                        exit();
                    } else {
                        header("Location: ../view/showAllUsersView.php?error=deleteUserNotFound");
                        exit();
                    }
                }
            }
        }
    }
}

function deleteUserLastLoginTime()
{
    if (isset($_POST) && isset($_POST['deleteUserLastLoginTimeSubmitButton'])) {
        $userService = new UserService();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $loggedInUserId = $_SESSION['loggedInUserData']->getId();
        $loggedInUser = $userService->getUserById($loggedInUserId);

        if (!isset($loggedInUser) || !$loggedInUser->isPermission('USER_DELETE')) {
            header("Location: ../view/showAllUsersView.php?error=notAllowed");
            exit();
        } else {
            $lastLoginDate = htmlspecialchars($_POST['lastLoginDate']);
            $lastLoginTime = htmlspecialchars($_POST['lastLoginTime']);

            if (!isset($lastLoginDate) || $lastLoginDate == "" || !isset($lastLoginTime) || $lastLoginTime == "") {
                $users = $userService->getUsers();
                session_start();
                $_SESSION['users'] = $users;

                header("Location: ../view/showAllUsersView.php?error=deleteDateOrTimeNotFound");
                exit();
            } else {
                $timeStamp = strtotime($lastLoginDate . " " . $lastLoginTime);

                // delete cartEntry from user before delete user

                $deleteSuccess = $userService->deleteUsersBeforeLastLoginTime($timeStamp);

                $users = $userService->getUsers();
                session_start();
                $_SESSION['users'] = $users;

                if ($deleteSuccess == true) {
                    header("Location: ../view/showAllUsersView.php?info=deleteSuccess");
                    exit();
                } else {
                    header("Location: ../view/showAllUsersView.php?error=deleteUserNotFound");
                    exit();
                }
            }
        }
    }
}
