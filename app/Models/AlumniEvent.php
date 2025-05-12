<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class AlumniEvent extends Model
    {
        use SoftDeletes;

        protected $table = 'alumni_events';

        protected $fillable = [
            'title',
            'description',
            'venue',
            'organizer_name',
            'event_date',
            'event_time',
            'fee',
            'contact_email',
            'contact_phone',
            'status',
        ];

        protected $dates = [
            'event_date',
            'event_time',
            'deleted_at',
        ];
    }
