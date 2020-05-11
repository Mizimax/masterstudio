<table>
    <thead>
    <tr>
        <th width="20">Activities</th>
        <th width="20">Masters</th>
        <th width="20">User Activity</th>
        <th width="20">Users</th>
        <th width="20">Follows</th>
        <th width="20">Income</th>
        <th width="20">Categories</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $allActivityCount }} Activities</td>
        <td>{{ $allMasterCount }} Masters</td>
        <td>{{ $allUserActivityCount }} Users</td>
        <td>{{ $allUserCount }} Users</td>
        <td>{{ $allFollowCount }} Follows</td>
        <td>{{ $totalIncome }} Bath</td>
        <td>{{ count($categories) }} Categories</td>
    </tr>
    </tbody>
</table>