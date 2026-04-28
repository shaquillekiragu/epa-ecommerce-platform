<?php

namespace console\seeders;

use yii\helpers\Console;

final class UserAddressSeeder extends BaseSeeder
{
    public function seed(int $debug = 1, int $batch_size = 25, int $count = 10): void
    {
        if ($count < 10) {
            throw new \InvalidArgumentException('This seeder currently expects $count >= 10 because linkups reference indices 0..9.');
        }

        $actor_id = $this->ensureSuperadminUserId();

        $users = $this->buildUsers($count, $this->seed_run_prefix);
        $users = $this->hashAllPasswords($users);
        $users = $this->applyAuditActor($users, $actor_id);
        $batched_users = array_chunk($users, $batch_size);

        $addresses = $this->buildAddresses($count);
        $user_addresses = $this->buildUserAddresses();

        $tx = $this->db->beginTransaction();

        try {
            Console::output('Seeding users...');
            $users_done = 0;
            $users_total = count($users);
            Console::startProgress(0, $users_total);
            $user_ids = $this->insertDataWithCallback(
                $batched_users,
                'user',
                true,
                static function () use (&$users_done, $users_total): void {
                    $users_done++;
                    Console::updateProgress($users_done, $users_total);
                }
            );
            Console::endProgress();

            $addresses_with_audit = $this->applyAuditActor($addresses, $actor_id);
            $batched_addresses = array_chunk($addresses_with_audit, $batch_size);
            Console::output('Seeding addresses...');
            $addresses_done = 0;
            $addresses_total = count($addresses_with_audit);
            Console::startProgress(0, $addresses_total);
            $address_ids = $this->insertDataWithCallback(
                $batched_addresses,
                'address',
                true,
                static function () use (&$addresses_done, $addresses_total): void {
                    $addresses_done++;
                    Console::updateProgress($addresses_done, $addresses_total);
                }
            );
            Console::endProgress();

            $user_address_rows = $this->mapUserAddressLinkups($user_addresses, $user_ids, $address_ids, $actor_id);
            $batched_user_address = array_chunk($user_address_rows, $batch_size);
            Console::output('Seeding user_address linkups...');
            $linkups_done = 0;
            $linkups_total = count($user_address_rows);
            Console::startProgress(0, $linkups_total);
            $this->insertDataWithCallback(
                $batched_user_address,
                'user_address',
                false,
                static function () use (&$linkups_done, $linkups_total): void {
                    $linkups_done++;
                    Console::updateProgress($linkups_done, $linkups_total);
                }
            );
            Console::endProgress();

            $tx->commit();

            if ($debug === 1) {
                Console::output('Seed complete:');
                Console::output('- users inserted: ' . count($user_ids));
                Console::output('- addresses inserted: ' . count($address_ids));
                Console::output('- user_address linkups inserted: ' . count($user_address_rows));
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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
                'allow_update' => 1,
                'allow_delete' => 1,
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

    private function mapUserAddressLinkups(array $linkup_groups, array $user_ids, array $address_ids, int $actor_id): array
    {
        $rows = [];

        foreach ($linkup_groups as $group) {
            foreach ($group as $link) {
                $user_idx = $link['user_idx'];
                $address_idx = $link['address_idx'];

                $rows[] = [
                    'user_id' => $user_ids[$user_idx],
                    'address_id' => $address_ids[$address_idx],
                    'created_by' => $actor_id,
                    'last_updated_by' => $actor_id,
                ];
            }
        }

        return $rows;
    }
}
