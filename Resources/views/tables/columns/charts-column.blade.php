{{--  
<div class="px-4 py-3 bg-gray-100 rounded-lg">
--}}
    <x-tables::columns.layout
        :components="$getComponents()"
        :record="$getRecord()"
        :record-key="$recordKey"
    />
{{--  
</div>
--}}