<?php

namespace console\seeders;

use yii\helpers\Console;

final class UserAddressSeeder extends BaseSeeder
{
    public function seed(int $debug = 1, int $batchSize = 25, int $count = 10): void
    {
        if ($count < 10) {
            throw new \InvalidArgumentException('This seeder currently expects $count >= 10 because linkups reference indices 0..9.');
        }

        $users = $this->buildUsers($count, $this->seedRunPrefix);
        $users = $this->hashAllPasswords($users);
        $batchedUsers = array_chunk($users, $batchSize);

        $addresses = $this->buildAddresses($count);
        $userAddresses = $this->buildUserAddresses();

        $tx = $this->db->beginTransaction();

        try {
            $userIds = $this->insertData($batchedUsers, 'user', true);

            $actorId = $this->getSuperadminUserId();
            if ($actorId === null) {
                throw new \RuntimeException('No RBAC assignment found for role "superadmin". Seed/assign a superadmin user first.');
            }

            $addressesWithAudit = $this->applyAuditActor($addresses, $actorId);
            $batchedAddresses = array_chunk($addressesWithAudit, $batchSize);
            $addressIds = $this->insertData($batchedAddresses, 'address', true);

            $userAddressRows = $this->mapUserAddressLinkups($userAddresses, $userIds, $addressIds, $actorId);
            $batchedUserAddress = array_chunk($userAddressRows, $batchSize);
            $this->insertData($batchedUserAddress, 'user_address', false);

            $tx->commit();

            if ($debug === 1) {
                Console::output('Seed complete:');
                Console::output('- users inserted: ' . count($userIds));
                Console::output('- addresses inserted: ' . count($addressIds));
                Console::output('- user_address linkups inserted: ' . count($userAddressRows));
            }
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }
    }

    private function buildUsers(int $count, string $prefix): array
    {
        $users = [
            [
                'role' => 'customer',
                'first_name' => 'Amina',
                'middle_names' => null,
                'last_name' => 'Diallo',
                'email' => 'amina.diallo+seed1@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1994-02-11',
                'country' => 'GB',
                'mobile_number' => '07000000001',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'merchant',
                'first_name' => 'Mateo',
                'middle_names' => 'Luis',
                'last_name' => 'Rossi',
                'email' => 'mateo.rossi+seed2@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1990-07-03',
                'country' => 'GB',
                'mobile_number' => '07000000002',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'customer',
                'first_name' => 'Noor',
                'middle_names' => null,
                'last_name' => 'Haddad',
                'email' => 'noor.haddad+seed3@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1996-11-19',
                'country' => 'GB',
                'mobile_number' => '07000000003',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'merchant',
                'first_name' => 'Arjun',
                'middle_names' => null,
                'last_name' => 'Patel',
                'email' => 'arjun.patel+seed4@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1989-05-27',
                'country' => 'GB',
                'mobile_number' => '07000000004',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'customer',
                'first_name' => 'Giulia',
                'middle_names' => 'Anne',
                'last_name' => 'Kowalski',
                'email' => 'giulia.kowalski+seed5@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1992-09-14',
                'country' => 'GB',
                'mobile_number' => '07000000005',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'merchant',
                'first_name' => 'Minjun',
                'middle_names' => null,
                'last_name' => 'Kim',
                'email' => 'minjun.kim+seed6@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1987-01-08',
                'country' => 'GB',
                'mobile_number' => '07000000006',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'customer',
                'first_name' => 'Putri',
                'middle_names' => null,
                'last_name' => 'Santos',
                'email' => 'putri.santos+seed7@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1998-03-22',
                'country' => 'GB',
                'mobile_number' => '07000000007',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'merchant',
                'first_name' => 'Diego',
                'middle_names' => 'Paul',
                'last_name' => 'Martínez',
                'email' => 'diego.martinez+seed8@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1991-12-30',
                'country' => 'GB',
                'mobile_number' => '07000000008',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'customer',
                'first_name' => 'Anh',
                'middle_names' => null,
                'last_name' => 'Nguyen',
                'email' => 'anh.nguyen+seed9@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1993-06-05',
                'country' => 'GB',
                'mobile_number' => '07000000009',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'role' => 'merchant',
                'first_name' => 'Sofia',
                'middle_names' => null,
                'last_name' => 'Müller',
                'email' => 'sofia.muller+seed10@example.com',
                'hashed_password' => 'Password123!',
                'date_of_birth' => '1988-10-17',
                'country' => 'GB',
                'mobile_number' => '07000000010',
                'is_active' => 1,
                'deactivated_at' => null,
                'created_by' => null,
                'last_updated_by' => null,
            ],
        ];

        $users = array_slice($users, 0, $count);

        foreach ($users as $i => $user) {
            $users[$i]['email'] = $prefix . $user['email'];
        }

        return $users;
    }

    private function buildAddresses(int $count): array
    {
        $addresses = [
            [
                'address_type' => 'shipping',
                'building_number' => '12',
                'street_name' => 'Baker Street',
                'city' => 'London',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'NW1 6XE',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'billing',
                'building_number' => '88',
                'street_name' => 'Fleet Street',
                'city' => 'London',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'EC4Y 1AA',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'shipping',
                'building_number' => '5',
                'street_name' => 'King Street',
                'city' => 'Manchester',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'M2 4LQ',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'billing',
                'building_number' => '41',
                'street_name' => 'High Street',
                'city' => 'Birmingham',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'B4 7SL',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'shipping',
                'building_number' => '27',
                'street_name' => 'George Street',
                'city' => 'Edinburgh',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'EH2 2LR',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'billing',
                'building_number' => '3',
                'street_name' => 'Castle Street',
                'city' => 'Cardiff',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'CF10 1BS',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'shipping',
                'building_number' => '19',
                'street_name' => 'Market Street',
                'city' => 'Leeds',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'LS1 6DT',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'billing',
                'building_number' => '66',
                'street_name' => 'Queen Street',
                'city' => 'Glasgow',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'G1 3DN',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'shipping',
                'building_number' => '101',
                'street_name' => 'Station Road',
                'city' => 'Bristol',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'BS1 4QA',
                'created_by' => null,
                'last_updated_by' => null,
            ],
            [
                'address_type' => 'billing',
                'building_number' => '22',
                'street_name' => 'Victoria Road',
                'city' => 'Liverpool',
                'region' => null,
                'country' => 'GB',
                'post_code' => 'L1 1JD',
                'created_by' => null,
                'last_updated_by' => null,
            ],
        ];

        return array_slice($addresses, 0, $count);
    }

    private function buildUserAddresses(): array
    {
        return [
            [
                // pair 1 shared
                ['user_idx' => 0, 'address_idx' => 0],
                ['user_idx' => 1, 'address_idx' => 0],
            ],
            [
                // pair 2 shared
                ['user_idx' => 2, 'address_idx' => 1],
                ['user_idx' => 3, 'address_idx' => 1],
            ],
            [
                // remaining single links
                ['user_idx' => 4, 'address_idx' => 2],
                ['user_idx' => 5, 'address_idx' => 3],
                ['user_idx' => 6, 'address_idx' => 4],
                ['user_idx' => 7, 'address_idx' => 5],
            ],
            [
                // one user with two addresses (not one of the shared-4)
                ['user_idx' => 8, 'address_idx' => 8],
                ['user_idx' => 8, 'address_idx' => 9],
            ],
            [
                // last user single link
                ['user_idx' => 9, 'address_idx' => 6],
            ],
        ];
    }

    private function mapUserAddressLinkups(array $linkupGroups, array $userIds, array $addressIds, int $actorId): array
    {
        $rows = [];

        foreach ($linkupGroups as $group) {
            foreach ($group as $link) {
                $userIdx = $link['user_idx'];
                $addressIdx = $link['address_idx'];

                $rows[] = [
                    'user_id' => $userIds[$userIdx],
                    'address_id' => $addressIds[$addressIdx],
                    'created_by' => $actorId,
                    'last_updated_by' => $actorId,
                ];
            }
        }

        return $rows;
    }
}
