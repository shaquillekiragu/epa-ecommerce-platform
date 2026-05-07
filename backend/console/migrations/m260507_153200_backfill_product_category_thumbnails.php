<?php

use yii\db\Migration;

/**
 * Backfills thumbnails on existing product_category rows.
 *
 * This only updates rows with NULL/empty thumbnails.
 */
class m260507_153200_backfill_product_category_thumbnails extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%product_category}}', 'thumbnail', $this->text()->null());

        $map = [
            1 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcZEI8yj9rt0ybIkNT0SInlRxsF48NCt-ZIMWyZSfS43VFNAqq9_MfZ9tfChxa9i631_REBy-tIwIxG4Gr96og_oNtAoNdZBTiD9P7Wa4bHS4tGAd0CYjawDrb8Jpp0Bf7xdC5_PGxzzeOeC8WgSOJdOavxqJtGAnOZmGjuNSPBvsun1OpRc5O2SrgFzWIxLGTbS39SuwGlni3_FghJxObu8G5_vYozactK4uJtYtUOF5AlBmSCeFiV0IREsSNIyei2W1kFyiiP9WV',
            2 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYqVG1bPAuaot8LZjYQTGUGL7oCrcQsxP2RydaWYvyg6YBL0FOqWIKaW5lyIKIeGtJ3ZO1dfiyNFgjtbOyaLbj_deHKdq6sbtyRuQt3-RQWl6BEveEPC7bZyssMLOtHl3NHTYEIeiYKFTUfzrM6QvZfp0SiEKv1jSvcpkHQ0XeJ7rM38Bv5uG4YJU7-JxRJrPjjgKiCuiHO3xYWlBgICpGgsps0H9TJXlN2d-DZl0zmyfjlAXcMQfy0rJ4INk3cdGwD-qJO4tjNYvK',
            3 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAYUS08R0Szh5Jx0wduYqRBT7Ki1k-wqfD9tMcvIlbxUrx7PywOmg5RsgyRGzVFMO5DhkARb1pbPx0tKm1oK9NGdbhSwpvK3tZ0LPlJ4VDloxyyMLavnqHsQbpGxsKJBohTF_wmQ9NQovfAxoeqaimXa2bKKaAFSXFseiFhsgnEoBfdb4GVVpS6UpPptgIYpYqN5PKoRZY8K9g_UyNC_aa1z2k-Do7T_Ux9qzmTAjQvISS9xoX4JuH_hhqdlveQPYgAjbh1lpl8E5Nm',
            4 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAlxnrWt_gMa7UF15hTXAen0wNOxGpFHbQ5fNZwF37f4in-0UQ5NnUoLKa7NJFAmzSYarAUK7G8Omq5nLGKCtkX5bMIT0ehkncGhL_LqeHk3aaNtziNFsGVpagutbkLCIJYne409JH7HUMEZlD0PJ7g9YCB0IvfFh2itfCdUUc6B__4UuQr8Jsh7xF3relYOmDznwYvcoHMGb_xRhazEO_iEJU60QhbJPwfpMEikqWoorYAzVinvpCpw4_glRR_fzCIQByP8GUVdXhB',
            5 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBzXGnXhpG9OzkZmpZz-B73aGTXl1iNy1fKSLWuKaqWRCRvbPtzKORyRSNQf9ayl93z_wosLPt1qg7kXzTsSCgDXINK8mZLbXfe8IccIRbkRe_tX5NPEQA-_8f-F0NOVFrqUi3QLG2j5A1vtPtkwW_fJa5u1nt95zkI8ha-hHMnF7vfPzuez2bh9aKytMTqwJDXYAMcsVW_IqRm-MfMTFnk1rtfFGxNOVJRqg-i-SfQ_-wl952-4-p5qRbncJf6vVtVH3-KmQOvhNa5',
            6 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA50OmyAKcg-1jOCo-NetkshDh_mmriA1RsStiBj1IJALJI86RY3Vm142_0LQByng0lGPfuho7GAMvfFLKfHTr5u-fFyz0swvy_4iDyMkNEjCAEytHD5gzWc4lXgVrWcNirVuPggYxfs7YVSawNtCXJtiUnURQnzJIxoj2b7EjiJLhCHpcKJZ4IayKSg-uol6vFeyYxi3zJWhIvuyI0WI5YumNtEM6xZ_vYBV5NeKzlSXOvfZq8n_Sj0IsYXoWv_lSu0UBn5D2sz3Tf',
            7 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAzUpBqQ-Bh3LcO7H9qydum8LaCWKG_VRcixf0RQmtfJJx6VFVtjtAoJsCVxsaub81rPxkEslhLIfrw7UTUPpr6-ztepNya5N5yAlPr2t4JMm7UMgW7V6Jhjh0enzrolb2YIkjt0gNAQnFwWf-451fiwIlZnLdySnp99FhtKuBlqhWT2_FCkGALUDCo_6Xv8udrnbdk9OrqkaSr_fp9emVDIJqLmm6sZ8GT7HU4kBkcjizWoiPJdQUVspgFvdU8qHDDtg-EpdNdVQC',
            8 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCPg5T2Q__xF4ZKGG7YG6x-vd1f27QP0r6gX54rsYW5T-rta_0X9K9zP6TeoibTptJmx31PkOdMK_7kA7sNFaXA_l5XP9t68VdVvVAjr2ubD9uW1-IFcr11H1MaP7xqW_Ad1e8hakxuakwRo2oduQbubIgFZ2LR4csfbYHlE6bc6L8QaooZ9w9nzVbBVoObD3beUyjVmht0KsbXc6dRf68ScZCPiKM-sdwfCKAJVT6Zx1L6O54FrLiTW20KVLk35eTnwrM7UrCldDUQ',
            9 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBanppMpZkWX00vOfTnPdov10Llx78bqqHkOuzZSrSLX-2pwl-W-_kT2xL88fkEy6G6Xl6kdTCqpH0YZjAuMNGWeiVFHEqu9VmiNV6WGGz6QxcPVl4C5wMhmE17e6cHkJkT3gwCYZ5F2FqgKZfTwWIt4N6FU0mlIsPoMp-OLtAdzuQqPZdjAMoC8sVX4a1xMvWRCsm5u3HSe8yHFecqYCUhNcHNJ86RbjrnJoh2iXQJXhKDbO6QTTJktKwUHYvg95VEDreJxKbgwHUN',
            10 => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBTefx-Zr7C3Zz09rxeBvmAXBZicGaXOe12Q22BL8OySXqwHFQsktmta50p3IZaQrHDzSZSrNfXJVygilydEZb_uHpKGWSYCqugICYGGaFaX2GQV_v-HY3DIax-dVRdWJqToCtDcg-_fYu2HyJzdIS_Q035sRN-tpS0ComlgmeVGVSpHK1BnqtGDtGAumyZyGo07KkRR-jXUnbZZWDQHcSVPZs1skgJeip5XsM3a8kfQd6A0PXozoNFp6xer71uGYZ9RsNKHiUMVi84',
        ];

        foreach ($map as $id => $thumbnail) {
            $this->update(
                '{{%product_category}}',
                ['thumbnail' => $thumbnail],
                ['and', ['id' => (int) $id], ['or', ['thumbnail' => null], ['thumbnail' => '']]]
            );
        }
    }

    public function safeDown()
    {
        return true;
    }
}
