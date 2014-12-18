@extends('layouts._form')

@section('title')
User Details
@stop

@section('panel_head')
Enter user details
{{ Form::open(array('url' =>
'/owner/create')) }}
@stop


@section('form1_field')
{{ Form::label('first_name','First Name') }}
{{Form::text('first_name',null,array('class'=>
'form-control')) }}
@stop

@section('form2_field')

{{ Form::label('last_name','Last Name') }}
{{Form::text('last_name',null,array('class'=>
'form-control')) }}
@stop

@section('form3_field')

{{ Form::label('address1','Address 1') }}
{{Form::text('address1',null,array('class'=>
'form-control')) }}
@stop

@section('form4_field')
{{ Form::label('address2','Address 2') }}
{{Form::text('address2',null,array('class'=>
'form-control')) }}
@stop

@section('form5_field')

{{ Form::label('city','City') }}
{{Form::text('city',null,array('class'=>
'form-control')) }}
@stop

@section('form6_field')

{{ Form::label('state','State') }}
{{ Form::select('state',array(
'AL'=>
'Alabama',
'AK'=>
'Alaska',
'AZ'=>
'Arizona',
'AR'=>
'Arkansas',
'CA'=>
'California',
'CO'=>
'Colorado',
'CT'=>
'Connecticut',
'DE'=>
'Delaware',
'DC'=>
'District of Columbia',
'FL'=>
'Florida',
'GA'=>
'Georgia',
'HI'=>
'Hawaii',
'ID'=>
'Idaho',
'IL'=>
'Illinois',
'IN'=>
'Indiana',
'IA'=>
'Iowa',
'KS'=>
'Kansas',
'KY'=>
'Kentucky',
'LA'=>
'Louisiana',
'ME'=>
'Maine',
'MD'=>
'Maryland',
'MA'=>
'Massachusetts',
'MI'=>
'Michigan',
'MN'=>
'Minnesota',
'MS'=>
'Mississippi',
'MO'=>
'Missouri',
'MT'=>
'Montana',
'NE'=>
'Nebraska',
'NV'=>
'Nevada',
'NH'=>
'New Hampshire',
'NJ'=>
'New Jersey',
'NM'=>
'New Mexico',
'NY'=>
'New York',
'NC'=>
'North Carolina',
'ND'=>
'North Dakota',
'OH'=>
'Ohio',
'OK'=>
'Oklahoma',
'OR'=>
'Oregon',
'PA'=>
'Pennsylvania',
'RI'=>
'Rhode Island',
'SC'=>
'South Carolina',
'SD'=>
'South Dakota',
'TN'=>
'Tennessee',
'TX'=>
'Texas',
'UT'=>
'Utah',
'VT'=>
'Vermont',
'VA'=>
'Virginia',
'WA'=>
'Washington',
'WV'=>
'West Virginia',
'WI'=>
'Wisconsin',
'WY'=>
'Wyoming',
) ,
Input::old('state'),
array(
'class'       =>
'form-control'
)) }}
@stop
@section('form7_field')

{{ Form::label('zip','Zip Code') }}
{{Form::text('zip_code',null,array('class'=>
'form-control')) }}
@stop

@section('form8_field')

{{ Form::submit('Submit',array('class'=>
'btn btn-success')) }}

{{ Form::close() }}
@stop


@section('errormsg')
@foreach($errors->
all() as $message)
{{ $message }}
@endforeach
@stop