<?php

namespace App\Models;

use App\Traits\ClearsResponseCache;
use ElipZis\Cacheable\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jedrzej\Searchable\SearchableTrait;
use Jedrzej\Sortable\SortableTrait;
use Mattiverse\Userstamps\Traits\Userstamps;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class BaseModel extends Model
{
    use Cacheable,
        HasFactory,
        HasUuids,
        SearchableTrait,
        SoftDeletes,
        SortableTrait,
        Userstamps;

    protected $guarded = ['id'];

    protected $searchable = ['*'];

    protected $notSearchable = ['per_page', 'page', 'sort', 'mode'];

    protected $sortable = ['*'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable($this->getTable());
    }
}
