<table>
    <thead>
    <tr>
        <th width="20">Month</th>
        <th width="20">Join activity user</th>
        <th width="20">Activities</th>
        <th width="20">Masters</th>
        <th width="20">Studios</th>
        <th width="20">Total income</th>
        <th width="20">@master income</th>
        <th width="20">Total sponsor</th>
        <th width="20">Stories</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $monthYear }}</td>
        <td>{{ $followCount }} Follows</td>
        <td>{{ $userActivityCount }} Users</td>
        <td>{{ $activityCount }} Activities</td>
        <td>{{ $masterCount }} Masters</td>
        <td>{{ $studioCount }} Studios</td>
        <td>{{ $totalIncome }} Baht</td>
        <td>{{ $totalIncome * 0.02 }} Baht</td>
        <td>0 Bath</td>
        <td>{{ $storyCount }} Stories uploaded</td>
    </tr>
    </tbody>
</table>