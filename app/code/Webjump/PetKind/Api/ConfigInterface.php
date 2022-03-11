<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Api;

interface ConfigInterface
{
    /**
     * @const PET_KIND_PATH
     */
    const PET_KIND_PATH = 'pets_section/pets_group/pets_field_enable';

    /**
     * This method will verify if this pet kind is enabled
     *
     * @param string|null $scopeCode
     * @return bool
     */
    public function isEnabled(?string $scopeCode): bool;
}
