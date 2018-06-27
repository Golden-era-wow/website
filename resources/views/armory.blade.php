@extends('layouts.app')

@section('content')
    <armory-index>
        <tabs slot-scope="{}">
            <tab name="pvp">
                <armory-pvp-ladder>

                </armory-pvp-ladder>
            </tab>

            <tab name="pve">
                <armory-pve-ladder>

                </armory-pve-ladder>
            </tab>

            <tab name="guilds">
                <armory-guilds-ladder>

                </armory-guilds-ladder>
            </tab>
        </tabs>
    </armory-index>
@endsection
