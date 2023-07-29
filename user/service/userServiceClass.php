<?php

/**
 * Service for all work with user between user and database.
 */
class UserService extends DatabaseService
{

    public function getLoggedInUserDataFromUser($user)
    {
        $cartService = new CartService();
        $cartEntryCount = $cartService->getCartEntrysCountByUserId($user->getId());

        $loggedInUserData = new LoggedInUserData($user->getId(), $user->getLoginName(), $user->getLastLoginTime(), $user->getRoles(), $cartEntryCount);

        return $loggedInUserData;
    }

    public function getEditOwnUserDataFromUser($user)
    {
        $editOwnUserData = new EditOwnUserData($user->getId(), $user->getLoginName());

        return $editOwnUserData;
    }

    public function getUserDataFromUser($user)
    {
        $userData = new UserData($user->getId(), $user->getLoginName(), $user->getRegistrationTime(), $user->getLastLoginTime(), $user->getActive(), $user->getRoles());

        return $userData;
    }

    public function isUserAvailable(int $userId)
    {
        $availableUser = false;

        $user = $this->getUserById($userId);

        if (isset($user)) {
            $availableUser = true;
        }

        return $availableUser;
    }

    public function createNotRegisteredUser($loginName)
    {
        $createSuccess = false;

        $salutation = $this->getSalutationById(1);
        $hashedPassword = password_hash('NOT_REGISTERED_USER', PASSWORD_DEFAULT);
        $roleName = "NOT_REGISTERED_USER";
        $role = $this->getRoleByName($roleName);
        $roles = array();
        array_push($roles, $role);
        $notRegisteredUser = new User(null, $loginName, $salutation, null, "Gast", "Gast", null, null, 'gast@gast.com', null, $hashedPassword, time(), time(), true, $roles);
        $createSuccess = $this->saveUser($notRegisteredUser);

        return $createSuccess;
    }

    public function getUserById($id)
    {
        $orderService = new OrderService();

        $sql = "SELECT users.id, users.login_name, users.salutation_id, users.title_before_name, users.first_name, users.last_name,
                users.title_after_name, users.phone_number, users.email, users.order_in_progress_id, users.password, users.registration_time, users.last_login_time, active
        FROM users
        WHERE users.id=?";

        $user = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));
            $rowUser = $statement->fetch();

            if (isset($rowUser['id'])) {
                $salutation = $this->getSalutationById($rowUser['salutation_id']);
                $orderInProgress = null;

                if ($rowUser['order_in_progress_id'] != null) {
                    $orderInProgress = $orderService->getOrderById($rowUser['order_in_progress_id']);
                }

                $roles = $this->getRolesByUserId($rowUser['id']);
                $user = new User(
                    $rowUser['id'],
                    $rowUser['login_name'],
                    $salutation,
                    $rowUser['title_before_name'],
                    $rowUser['first_name'],
                    $rowUser['last_name'],
                    $rowUser['title_after_name'],
                    $rowUser['phone_number'],
                    $rowUser['email'],
                    $orderInProgress,
                    $rowUser['password'],
                    $rowUser['registration_time'],
                    $rowUser['last_login_time'],
                    $rowUser['active'],
                    $roles
                );
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getUserById($id) ----- ";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $user;
    }

    public function getUserByOrderId($id)
    {
        $orderService = new OrderService();

        $sql = "select users.id, users.login_name, users.salutation_id, users.title_before_name, users.first_name, users.last_name, users.title_after_name, 
		                    users.phone_number, users.email, users.order_in_progress_id, users.password, users.registration_time, users.last_login_time, users.active
                    from users
                    left join users_to_orders
                    on users.id = users_to_orders.user_id
                    where users_to_orders.order_id=?";

        $user = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));
            $rowUser = $statement->fetch();

            if (isset($rowUser['id'])) {
                $salutation = $this->getSalutationById($rowUser['salutation_id']);
                $orderInProgress = null;

                if ($rowUser['order_in_progress_id'] != null) {
                    $orderInProgress = $orderService->getOrderById($rowUser['order_in_progress_id']);
                }

                $roles = $this->getRolesByUserId($rowUser['id']);
                $user = new User(
                    $rowUser['id'],
                    $rowUser['login_name'],
                    $salutation,
                    $rowUser['title_before_name'],
                    $rowUser['first_name'],
                    $rowUser['last_name'],
                    $rowUser['title_after_name'],
                    $rowUser['phone_number'],
                    $rowUser['email'],
                    $orderInProgress,
                    $rowUser['password'],
                    $rowUser['registration_time'],
                    $rowUser['last_login_time'],
                    $rowUser['active'],
                    $roles
                );
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getUserByOrderId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $user;
    }

    public function getUserByLoginName($loginName)
    {
        $orderService = new OrderService();

        $sql = "SELECT users.id, users.login_name, users.salutation_id, users.title_before_name, users.first_name, users.last_name,
                users.title_after_name, users.phone_number, users.email, users.order_in_progress_id, users.password, users.registration_time, users.last_login_time, active
            FROM users 
            WHERE login_name=?";

        $user = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($loginName));
            $rowUser = $statement->fetch();

            if (isset($rowUser['id'])) {
                $salutation = $this->getSalutationById($rowUser['salutation_id']);
                $orderInProgress = null;

                if ($rowUser['order_in_progress_id'] != null) {
                    $orderInProgress = $orderService->getOrderById($rowUser['order_in_progress_id']);
                }

                $roles = $this->getRolesByUserId($rowUser['id']);
                $user = new User(
                    $rowUser['id'],
                    $rowUser['login_name'],
                    $salutation,
                    $rowUser['title_before_name'],
                    $rowUser['first_name'],
                    $rowUser['last_name'],
                    $rowUser['title_after_name'],
                    $rowUser['phone_number'],
                    $rowUser['email'],
                    $orderInProgress,
                    $rowUser['password'],
                    $rowUser['registration_time'],
                    $rowUser['last_login_time'],
                    $rowUser['active'],
                    $roles
                );
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getUserByLoginName($loginName) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $user;
    }

    public function getUserByEmail($email)
    {
        $orderService = new OrderService();

        $sql = "SELECT users.id, users.login_name, users.salutation_id, users.title_before_name, users.first_name, users.last_name,
                users.title_after_name, users.phone_number, users.email, users.order_in_progress_id, users.password, users.registration_time, users.last_login_time, active
            FROM users 
            WHERE email=?";

        $user = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($email));
            $rowUser = $statement->fetch();

            if (isset($rowUser['id'])) {
                $salutation = $this->getSalutationById($rowUser['salutation_id']);
                $orderInProgress = null;

                if ($rowUser['order_in_progress_id'] != null) {
                    $orderInProgress = $orderService->getOrderById($rowUser['order_in_progress_id']);
                }

                $roles = $this->getRolesByUserId($rowUser['id']);
                $user = new User(
                    $rowUser['id'],
                    $rowUser['login_name'],
                    $salutation,
                    $rowUser['title_before_name'],
                    $rowUser['first_name'],
                    $rowUser['last_name'],
                    $rowUser['title_after_name'],
                    $rowUser['phone_number'],
                    $rowUser['email'],
                    $orderInProgress,
                    $rowUser['password'],
                    $rowUser['registration_time'],
                    $rowUser['last_login_time'],
                    $rowUser['active'],
                    $roles
                );
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getUserByEmail($email) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $user;
    }

    public function getUsers()
    {
        $orderService = new OrderService();

        $sql = "SELECT users.id, users.login_name, users.salutation_id, users.title_before_name, users.first_name, users.last_name,
                users.title_after_name, users.phone_number, users.email, users.order_in_progress_id, users.password, users.registration_time, users.last_login_time, active
                    FROM users
                    WHERE users.id>0";

        $users = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($rowUser = $statement->fetch()) {
                $salutation = $this->getSalutationById($rowUser['salutation_id']);
                $orderInProgress = null;

                if ($rowUser['order_in_progress_id'] != null) {
                    $orderInProgress = $orderService->getOrderById($rowUser['order_in_progress_id']);
                }

                $roles = $this->getRolesByUserId($rowUser['id']);
                $user = new User(
                    $rowUser['id'],
                    $rowUser['login_name'],
                    $salutation,
                    $rowUser['title_before_name'],
                    $rowUser['first_name'],
                    $rowUser['last_name'],
                    $rowUser['title_after_name'],
                    $rowUser['phone_number'],
                    $rowUser['email'],
                    $orderInProgress,
                    $rowUser['password'],
                    $rowUser['registration_time'],
                    $rowUser['last_login_time'],
                    $rowUser['active'],
                    $roles
                );
                array_push($users, $user);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getUsers() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $users;
    }

    private function getRolesByUserId($id)
    {
        $roles = array();
        $sql = "select roles.id, roles.name
            from roles
            left join users_to_roles
            on roles.id = users_to_roles.role_id
            where users_to_roles.user_id = ?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $permissions = $this->getPermissionsByRoleId($row['id']);

                $role = new Role($row['id'], $row['name'], $permissions);
                array_push($roles, $role);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getRolesByUserId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $roles;
    }

    private function getUserPersonalDataById($id)
    {
        $userPersonalData = null;

        if ($id != null && $id > 0) {
            $sql = "select user_personal_datas.id, user_personal_datas.salutation_id, user_personal_datas.title, user_personal_datas.first_name, user_personal_datas.last_name, user_personal_datas.phone_number, user_personal_datas.email
            from user_personal_datas
            where user_personal_datas.id = ?";

            try {
                $pdo = $this->getPDO();

                $statement = $pdo->prepare($sql);
                $statement->execute(array($id));

                while ($row = $statement->fetch()) {
                    $salutation = $this->getSalutationById($row['salutation_id']);
                    $userPersonalData = new UserPersonalData($row['id'], $salutation, $row['title'], $row['first_name'], $row['last_name'], $row['phone_number'], $row['email'], array());
                    break;
                }

                $statement->closeCursor();
                $statement = null;
                $pdo = null;
            } catch (PDOException $e) {
                echo " ----- Failed to connect to MySQL: ----- getUserPersonalDataById($id) -----";
                $pdo = null;
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return $userPersonalData;
    }

    public function getSalutationById($id)
    {
        $salutation = null;

        $sql = "select salutations.id, salutations.name, salutations.description
            from salutations
            where salutations.id = ?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $salutation = new Salutation($row['id'], $row['name'], $row['description']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getSalutationById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $salutation;
    }

    public function getSalutations()
    {
        $salutations = array();

        $sql = "select salutations.id, salutations.name, salutations.description
            from salutations";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $salutation =  new Salutation($row['id'], $row['name'], $row['description']);
                array_push($salutations, $salutation);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getSalutations() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $salutations;
    }

    public function getAddressById($id)
    {
        $address = null;

        $sql = "select id, salutation_id, title_before_name, first_name, last_name, title_after_name, phone_number, email,
                            country_id, postal_code, location, address_line_1, address_line_2, vatId
                from addresses
                where id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $salutation = $this->getSalutationById($row['salutation_id']);
                $country = $this->getCountryById($row['country_id']);
                $address = new \Address(
                    $row['id'],
                    $salutation,
                    $row['title_before_name'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['title_after_name'],
                    $row['phone_number'],
                    $row['email'],
                    $country,
                    $row['postal_code'],
                    $row['location'],
                    $row['address_line_1'],
                    $row['address_line_2'],
                    $row['vatId']
                );

                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getAddressById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $address;
    }

    public function getCountryById($id)
    {
        $country = null;

        $sql = "select id, name
                from countries
                where id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $country = new Country($row['id'], $row['name']);
                break;
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCountryById($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $country;
    }

    public function getCountries()
    {
        $countries = array();

        $sql = "select countries.id, countries.name
            from countries";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $country = new Country($row['id'], $row['name']);
                array_push($countries, $country);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getCountries() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $countries;
    }

    public function getRoleByName($name)
    {
        $sql = 'select roles.id, roles.name from roles
                    where roles.name like ?';

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($name));

            $row = $statement->fetch();
            $permissions = $this->getPermissionsByRoleId($row['id']);
            $role = new Role($row['id'], $row['name'], $permissions);

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getRoleByName($name) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $role;
    }

    public function getRoles()
    {
        $sql = "select id, name
                    from roles
                    where roles.id > 0";

        $roles = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->query($sql);

            while ($row = $statement->fetch()) {
                $permissions = $this->getPermissionsByRoleId($row['id']);
                $role = new Role($row['id'], $row['name'], $permissions);
                array_push($roles, $role);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getRoles() -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $roles;
    }

    private function getPermissionsByRoleId($id)
    {
        $sql = "select permissions.id, permissions.name
            from roles
            left join permissions_to_roles
            on roles.id = permissions_to_roles.role_id
            left join permissions
            on permissions_to_roles.permission_id = permissions.id
            where roles.id = ?";

        $permissions = array();

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $statement->execute(array($id));

            while ($row = $statement->fetch()) {
                $permission = new Permission($row['id'], $row['name']);
                array_push($permissions, $permission);
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- getPermissionsByRoleId($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $permissions;
    }

    public function saveLastLoginTimeForUser($user, $lastLoginTime)
    {
        $sql = "update users set last_login_time=? where id=?";
        return $this->updateLastLoginTimeForUser($sql, array($lastLoginTime, $user->getId()));
    }

    private function updateLastLoginTimeForUser($sql, $parameters)
    {
        $updateSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateLastLoginTimeForUser($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $updateSuccess;
    }

    public function saveAddress($address)
    {
        $addressId = null;

        if ($address->getId() == null) {
            // insert new address
            $sql = "insert into addresses (salutation_id, title_before_name, first_name, last_name, title_after_name, phone_number, email,
                                            country_id, postal_code, location, address_line_1, address_line_2, vatId) 
                                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $addressId = $this->insertAddress($sql, array(
                $address->getSalutation()->getId(), $address->getTitleBeforeName(), $address->getFirstName(), $address->getLastName(), $address->getTitleAfterName(), $address->getPhoneNumber(), $address->getEmail(),
                $address->getCountry()->getId(), $address->getPostalCode(), $address->getLocation(), $address->getAddressLine1(), $address->getAddressLine2(), $address->getVatId()
            ));
        } else {
            // update existed address
            $sql = "update addresses set salutation_id=?, title_before_name=?, first_name=?, last_name=?, title_after_name=?, phone_number=?, email=?,
                country_id=?, postal_code=?, location=?, address_line_1=?, address_line_2=?, vatId=?
                where id=?";
            $addressId = $this->updateAddress($sql, array(
                $address->getSalutation()->getId(), $address->getTitleBeforeName(), $address->getFirstName(), $address->getLastName(), $address->getTitleAfterName(), $address->getPhoneNumber(), $address->getEmail(),
                $address->getCountry()->getId(), $address->getPostalCode(), $address->getLocation(), $address->getAddressLine1(), $address->getAddressLine2(), $address->getVatId(), $address->getId()
            ));
        }

        return $addressId;
    }

    private function insertAddress($sql, $parameters)
    {
        $addressId = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute($parameters);

            if ($insertSuccess == true) {
                $addressId = $pdo->lastInsertId();
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- insertAddress($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $addressId;
    }

    private function updateAddress($sql, $parameters)
    {
        $addressId = null;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            if ($updateSuccess == true) {
                $addressId = $parameters[13];
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateAddress($sql, $parameters) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $addressId;
    }

    public function saveUser($user)
    {
        $insertSuccess = true;

        $orderService = new OrderService();

        if ($user->getOrderInProgress() != null) {
            $orderId = $orderService->saveOrder($user->getOrderInProgress(), $user->getId());
            $user->getOrderInProgress()->setId($orderId);
        }

        if ($insertSuccess) {
            if ($user->getId() == null) {
                // insert new user
                $sql = "INSERT INTO users (login_name, salutation_id, title_before_name, first_name, last_name,
                            title_after_name, phone_number, email, order_in_progress_id, password, registration_time, last_login_time, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertSuccess = $this->insertUser($sql, array(
                    $user->getLoginName(), $user->getSalutation()->getId(), $user->getTitleBeforeName(), $user->getFirstName(), $user->getLastName(),
                    $user->getTitleAfterName(), $user->getPhoneNumber(), $user->getEmail(), $user->getOrderInProgress() != null ? $user->getOrderInProgress()->getId() : null, $user->getPassword(), $user->getRegistrationTime(), $user->getLastLoginTime(), $user->getActive()
                ), $user->getRoles());
            } else {
                // update existed user
                $sql = "update users set login_name=?, salutation_id=?, title_before_name=?, first_name=?, last_name=?,
                            title_after_name=?, phone_number=?, email=?, order_in_progress_id=?, password=?, registration_time=?, last_login_time=?, active=? where id=" . $user->getId();
                $insertSuccess =  $this->updateUser($sql, array(
                    $user->getLoginName(), $user->getSalutation()->getId(), $user->getTitleBeforeName(), $user->getFirstName(), $user->getLastName(),
                    $user->getTitleAfterName(), $user->getPhoneNumber(), $user->getEmail(), $user->getOrderInProgress() != null ? $user->getOrderInProgress()->getId() : null, $user->getPassword(), $user->getRegistrationTime(), $user->getLastLoginTime(), $user->getActive()
                ), $user->getRoles());
            }
        }

        return $insertSuccess;
    }

    private function insertUser($sql, $parameters, $roles)
    {
        $insertSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute($parameters);

            if ($insertSuccess == true) {
                $insertedUser = $this->getUserByLoginName($parameters[0]);

                if (isset($insertedUser)) {
                    $userId = $insertedUser->getId();

                    foreach ($roles as $role) {
                        $roleId = $role->getId();
                        $this->addRoleToUser($roleId, $userId);
                    }
                }
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- insertUser($sql, $parameters, $roles) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $insertSuccess;
    }

    private function updateUser($sql, $parameters, $roles)
    {
        $updateSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $updateSuccess = $statement->execute($parameters);

            if ($updateSuccess == true) {
                $user = $this->getUserByLoginName($parameters[0]);
                $this->removeAllRolesFromUser($user->getId());

                foreach ($roles as $role) {
                    $this->addRoleToUser($role->getId(), $user->getId());
                }
            }

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- updateUser($sql, $parameters, $roles) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $updateSuccess;
    }

    public function deleteUser($id)
    {
        $deleteSuccess = false;

        // delete cartEntrys from the user
        $cartService = new CartService();
        $cartEntrys = $cartService->getCartEntrysByUserId($id);

        if (isset($cartEntrys) && count($cartEntrys) > 0) {
            foreach ($cartEntrys as $cartEntry) {
                $cartService->removeProductFromCart($cartEntry);
            }
        }

        // delete the user
        $sql = "DELETE FROM users WHERE id=?";

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $deleteSuccess = $statement->execute(array($id));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- deleteUser($id) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $deleteSuccess;
    }

    public function deleteUsersBeforeLastLoginTime($lastLoginTime)
    {
        $deleteSuccess = false;

        $sql = "delete from users where id in 
            (select t.id from (select users.id, roles.name from users
            left join users_to_roles
            on users.id = users_to_roles.user_id
            left join roles
            on users_to_roles.role_id = roles.id
            where roles.name not like 'ADMIN' and last_login_time < ?) as t)";

        $deleteSuccess = false;
        $pdo = null;

        try {
            $pdo = $this->getPDO();
            $pdo->beginTransaction();

            $sqlBefore = "SET SQL_SAFE_UPDATES=0";
            $statement = $pdo->query($sqlBefore);

            $statement = $pdo->prepare($sql);
            $deleteSuccess = $statement->execute(array($lastLoginTime));

            $sqlAfter = "SET SQL_SAFE_UPDATES=1";
            $statement = $pdo->query($sqlAfter);

            $pdo->commit();

            $statement->closeCursor();
            $statement = null;
            // $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- deleteUsersBeforeLastLoginTime($lastLoginTime) -----";
            $pdo->rollBack();
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $pdo = null;

        return $deleteSuccess;
    }

    private function addRoleToUser($roleId, $userId)
    {
        $sql = "INSERT INTO users_to_roles (user_id, role_id) VALUES (?, ?);";

        $insertSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $insertSuccess = $statement->execute(array($userId, $roleId));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- addRoleToUser($roleId, $userId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $insertSuccess;
    }

    private function removeAllRolesFromUser($userId)
    {
        $sql = "delete from users_to_roles
            where user_id = ?";

        $deleteSuccess = false;

        try {
            $pdo = $this->getPDO();

            $statement = $pdo->prepare($sql);
            $deleteSuccess = $statement->execute(array($userId));

            $statement->closeCursor();
            $statement = null;
            $pdo = null;
        } catch (PDOException $e) {
            echo " ----- Failed to connect to MySQL: ----- removeAllRolesFromUser($userId) -----";
            $pdo = null;
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $deleteSuccess;
    }

    public function isRoleByUserId($userId, $roleName)
    {
        $user = $this->getUserById($userId);
        return $user->isRole($roleName);
    }

    public function isPermissionByUserId($userId, $permissionName)
    {
        $user = $this->getUserById($userId);
        return $user->isPermission($permissionName);
    }

    public function testInputsForEditUser($id, $loginName, $oldPassword, $password, $passwordRepeat)
    {
        $errorMessage = null;

        $user = $this->getUserById($id);

        if (isset($user)) {
            if ($loginName != $user->getLoginName()) {
                // test the new name if it exist in the database (same name is not allowed)
                $searchedUser = $this->getUserByLoginName($loginName);

                if (isset($searchedUser)) {
                    return "userExist";
                }
            }

            $passwordCheck = password_verify($oldPassword, $user->getPassword());

            if ($passwordCheck == false) {
                return "wrongLoginNameOrPassword";
            }
        } else {
            return "wrongLoginNameOrPassword";
        }

        $errorMessage = $this->testInputsForUser($loginName, $password, $passwordRepeat);

        return $errorMessage;
    }

    public function testInputsForEditOwnUser($id, $loginName, $oldPassword, $newPassword, $newPasswordRepeat)
    {
        $errorMessage = null;

        $user = $this->getUserById($id);

        if (isset($user)) {
            if ($loginName != $user->getLoginName()) {
                // test the new name if it exist in the database (same name is not allowed)
                $searchedUser = $this->getUserByLoginName($loginName);

                if (isset($searchedUser)) {
                    return "userExist";
                }
            }

            $passwordCheck = password_verify($oldPassword, $user->getPassword());

            if ($passwordCheck == false) {
                return "wrongLoginNameOrPassword";
            }
        } else {
            return "wrongLoginNameOrPassword";
        }

        $errorMessage = $this->testInputsForUser($loginName, $newPassword, $newPasswordRepeat);

        return $errorMessage;
    }

    public function testInputsForCreateUser($createUserData)
    {
        $errorMessage = null;

        $errorMessage = $this->testInputsForUser($createUserData);

        if ($errorMessage != null) {
            return $errorMessage;
        }

        // look for exist loginName
        $user = $this->getUserByLoginName($createUserData->getLoginName());

        if (isset($user)) {
            return "loginNameExist";
        }

        // look for exist email
        $user = $this->getUserByEmail($createUserData->getEmail());

        if (isset($user)) {
            return "emailExist";
        }

        return $errorMessage;
    }

    private function testInputsForUser($createUserData)
    {
        $errorMessage = null;

        if (
            empty($createUserData->getLoginName()) || empty($createUserData->getFirstName()) || empty($createUserData->getLastName())
            || empty($createUserData->getEmail()) || empty($createUserData->getPassword()) || empty($createUserData->getPasswordRepeat())
        ) {
            return "emptyField";
        }

        if (strlen($createUserData->getLoginName()) < 3 || !preg_match("/^[a-zA-Z0-9]*$/", $createUserData->getLoginName())) {
            return "invalidLoginName";
        }

        if (!filter_var($createUserData->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return "invalidEmail";
        }

        if (strlen($createUserData->getPassword()) < 8) {
            return "invalidPassword";
        } else if (preg_match("/^[äöüÄÖÜß]*$/", $createUserData->getPassword())) {
            return "invalidPassword";
        } else if (!preg_match("/^[a-zA-Z0-9\!\§\%]*$/", $createUserData->getPassword())) {
            return "invalidPassword";
        }

        if ($createUserData->getPassword() !== $createUserData->getPasswordRepeat()) {
            return "invalidPasswordCheck";
        }

        return $errorMessage;
    }

    public function testInputsForCreateAddress($createAddressData)
    {
        $errorMessage = null;

        if (
            empty($createAddressData->getFirstName()) || empty($createAddressData->getLastName()) || empty($createAddressData->getPhoneNumber())
            || empty($createAddressData->getEmail()) || $createAddressData->getCountryId() <= 1 || empty($createAddressData->getPostalCode())
            || empty($createAddressData->getLocation()) || empty($createAddressData->getAddressLine1()) || empty($createAddressData->getVatId())
        ) {
            return "emptyField";
        }

        if (!filter_var($createAddressData->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return "invalidEmail";
        }

        return $errorMessage;
    }

    public function getCreateAddressDataFromAddress($address)
    {
        $createAddressData = new CreateAddressData(
            $address->getId(),
            $address->getSalutation()->getId(),
            $address->getTitleBeforeName(),
            $address->getFirstName(),
            $address->getLastName(),
            $address->getTitleAfterName(),
            $address->getPhoneNumber(),
            $address->getEmail(),
            $address->getCountry()->getId(),
            $address->getPostalCode(),
            $address->getLocation(),
            $address->getAddressLine1(),
            $address->getAddressLine2(),
            $address->getVatId()
        );

        return $createAddressData;
    }

    public function getConfirmAddressDataFromAddress($address)
    {
        $confirmAddressData = new ConfirmAddressData(
            $address->getId(),
            $address->getSalutation()->getName(),
            $address->getTitleBeforeName(),
            $address->getFirstName(),
            $address->getLastName(),
            $address->getTitleAfterName(),
            $address->getPhoneNumber(),
            $address->getEmail(),
            $address->getCountry()->getName(),
            $address->getPostalCode(),
            $address->getLocation(),
            $address->getAddressLine1(),
            $address->getAddressLine2(),
            $address->getVatId()
        );

        return $confirmAddressData;
    }

    public function getCompactInvoiceAddress($order) 
    {
        $compactAddress = null;

        if ($order->getInvoiceAddress() != null) {
            $compactAddress = "";

            $address = $order->getInvoiceAddress();

            if ($address->getTitleBeforeName() != null) {
                $compactAddress .= $address->getTitleBeforeName() . " ";
            }

            if ($address->getFirstName() != null) {
                $compactAddress .= $address->getFirstName() . " ";
            }

            if ($address->getLastName() != null) {
                $compactAddress .= $address->getLastName() . " ";
            }

            if ($address->getTitleAfterName() != null) {
                $compactAddress .= $address->getTitleAfterName();
            }
        }

        return $compactAddress;
    }

    public function getCompactDeliveryAddress($order) 
    {
        $compactAddress = null;

        if ($order->getDeliveryAddress() != null) {
            $compactAddress = "";

            $address = $order->getDeliveryAddress();

            if ($address->getTitleBeforeName() != null) {
                $compactAddress .= $address->getTitleBeforeName() . " ";
            }

            if ($address->getFirstName() != null) {
                $compactAddress .= $address->getFirstName() . " ";
            }

            if ($address->getLastName() != null) {
                $compactAddress .= $address->getLastName() . " ";
            }

            if ($address->getTitleAfterName() != null) {
                $compactAddress .= $address->getTitleAfterName();
            }
        }

        return $compactAddress;
    }
}
