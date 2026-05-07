<?php

use yii\db\Migration;

/**
 * Backfills product.thumbnail with usable image URLs.
 *
 * Updates rows where thumbnail is NULL/empty OR looks like a local "*.jpg" filename.
 */
class m260507_165400_backfill_product_thumbnails extends Migration
{
    public function safeUp()
    {
        $map = [
            1 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCsP0brIpa6RGliR_LnX4sKRoU5eofeW1Zk-j5zSAUHJHWywKONN3xutvNBjQpCbpTzsdzDjaodtQdAobDg5IdvQHpgtfq3FaqvjCSCFj3Qmj4MD2IWh16tSuPlEesIixtZ25WnDiKO_itfhOglNTyzQluQspQP4th8BOtniEuiiwHRvCBCnyaD58107jfhA16-4ZfqVBw65LPFjiXh8ym2fz-UqwxHxyjnIO9_cCZgZlMGXadqHIXuXb6bSgGfuCHtzqQsA3W0B0EL',
            2 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAfAjzhD8IU1hWkHsvqBsDKhVYKRzeaPsQZw6Ksx4OK20eyklJ2SgIB2hQBUsikftc4iAck2LsyhcdhRwHT1iw_MYG8sb3afvCeIRfYx7I3LkZ-zQ5lEPo8q39XdWeBVDZK8d5JOzIeHUFCvvP8Txcpva7_HLVh4Yv8Hc8VixszV-zV6MjI3x3FcYhBKichpNVsYrHcsoyp3lvhFtD2-hTMTwNCZSQo8-zwFpxRwq2Z0C5d24UzjTLP9wPYXdk37OKiPP5FdogM37yj',
            3 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC2Jql8K5UdayOQMiRYTUtVqzjTtl1kTUG4DHWLWEmePyWLIu15We9UGWolWc97oLi80pi6TkEEf4Z3uSN--d6bvNVogVfDNzjpQLd_GMaXh23pu98CKy7q3itlpdeItGbCwl6lh9OHtrl8o8NKyzhliECJSklJ-336EW4AxVeIDfzhKbfd3dw8ZIBrBl3p-5wLXZjoo5KsNIg4kbtOFxYteJOxrOirLTSWF6xUsRl6CgpyZ1pGTIR17WXKF9sAxlRKEWH0exKyfEL1',
            4 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDqds0N5VSs_xqnweqTXweffd1SP4Ou_G0Ms46keqhH9JUd6ze4Ty7sgUJqhgQnzStyX6FhEFTn8uTJMYJ2tJ9GlDzQB5qsHYfloeMcpLq9B4yQ67KasblOOHwnoREEdOrK-bf2W3RDxbjfAGgBk_IU5JdThQ6os2c26OLr_f91CTxg2lRhMJqZ1p6Ljxcfkh_DFHR1HBT5BOYIrSLMPd8J50Rc5nCEVbgh4dshjraDcV8d-a3cYE-BDlZDT3d6wNDL1svgJ7qErbHf',
            5 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3mmh9SuMl1xwD_2o2o-EkxHu8QFn75ViLccU-0EgWew5gEvbOtH5ZcErmU_sN9SkMhKB0Ytb4S0O5PQY-GUFKRzdllvWUj9b8BOWZPHbq19H0_dePI46SLiv21IS0utkvinCeCuxxkQQYinjr4lqIVH5tEo6Sls3E7Dtm9fiNzXuM2rDwlj2vC4gitJaX1h83hFiXVL6CA7dd8DUjJHhwwKNizo80iQoUW6SP1QebFORaUj14GjMdqsfhBezv8BIkR5AuCEqMg-Nd',
            6 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCZLj9bNLJUvpnZnLY6Bgiq86rRGjK2VVcSLZClJOge_S2Tv5zAzuLmRDTpKQShlBcVLq36KuSPdFBATFtnxSk-PjSJ0leE6Owci32IethpNSvKmsNr8NPz8IDGWLk0G-oZyHeRSez5nwhrCs9EahKl7rahi6QvJIJaD9lz2wVuU70P3yO04cfz3B1CrwCqc5XXYztfBlYHRlIFQ5UJnkLbIZEiJQdQGrzFuXRGFX3dS_RZAf_bYUcghps7XFODtiEy7irhvzTRXkmH',
            7 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCQ7vYmK39cpanEbP9F_pl6TIhEBm-aND7rHyKQq24df7sbqColT6VBVsEgNYOiVINfMgUX0ZFkaIoNm5PBMXdd_tP0BrMBdiakyJ6nBf-hyiE4bzAWM6NhA4cKS41tqCxsvMtru2Fy2iRgkmsa2wxz7XNpsyNNfvD5nI6unJ0pCgcLZCc8ambrAyCvaQh7dexb5tftSo3UM7jQvdvGTKY6ZVHod1I8h8ehbwfLFZ07852Vk9DdmaZhKQmSKtfRKoLBqsgDO1wbHy2O',
            8 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAcVgGwt4aWVGaYQcJJepzaJ-xNl3z7E6G48286Yz3etaO7q_2bhtkrtSkbWFQ-J5AQLVi-KDhJ7d2hzLB4wQUG5NQuVZlWgHIu1ZPSJnDGNz7Yk9i6-8wlNatBlHXRDzy7Rz94CbjQruG4Flit_la3LW6b8i5TiD_9Pklel5jhiYF1kY4MJPOUFXeInvQrqo0jy_NPRcW1vnc3KYk4KVoE414zySa7ADjiEgmDKL_lNCwBW9NZOJJrRFsvt6ML_F3lFCzKNaPVGhog',
            9 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDw5N8KG4aAtFEMnURXEZhMB3XWiqMw_z5ICFuVotuv96IB7TxXPBvM5dowp2pBjaTReP1ukinnsU_fuvIR4SEXXzDc7WdKxZwGIwDRFUKQ49Mpax0n8-uaPr-XKQf4Qp-_Un15P15ngh5RkYjo54ZlqVrqhZZvjsxzVRO1lQQhScsBWw4vYe8DYEvPM3ZbL_I-sM6pJAttH-fYPSc1UQ5hij-tJNykYukGDnKZLfsV2ogyYvrn51ODfmcpn2t5oGhlR34e12NRmzTw',
            10 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAapD6o2qZSRK-NbGnk5uT9cBMw6prkPlo3wtEd6dBj6EDIsfL1OWUoCZ46XrUiGE9cyUoqp48GP8Mi05APwvMW3wBHrAX6r0ACbOE3vxvGbG7qQE6OseMDqGjeZITGRhm5dUtc03YI4rmtghSUXnDeh2x_eZ_6V8_dU98Tm3wlmYPmd-A7-F2HFjGHHm8RPHPirdjMxKEzCJYakpDjdi_5Rl66npqva6c93VZdr888LPk7D-2u0H51k1sM53m40udymHej2_brn5QZ',
        ];

        foreach ($map as $id => $thumbnail) {
            // Only update "bad" thumbnails.
            $this->update(
                '{{%product}}',
                ['thumbnail' => $thumbnail],
                [
                    'and',
                    ['id' => (int) $id],
                    [
                        'or',
                        ['thumbnail' => null],
                        ['thumbnail' => ''],
                        ['like', 'thumbnail', '%.jpg', false],
                    ],
                ]
            );
        }
    }

    public function safeDown()
    {
        // Non-destructive backfill; do not revert.
        return true;
    }
}
