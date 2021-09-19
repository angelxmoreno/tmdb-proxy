<?php
declare(strict_types=1);

namespace TmdbProxy\DataSource\User;

use Atlas\Table\TableSelect;

/**
 * @method UserRow|null fetchRow()
 * @method UserRow[] fetchRows()
 */
class UserTableSelect extends TableSelect
{
}
