<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// TODO: Improve this code!

// 1. **Make a Repository:**
// TODO: Create a User Repository and Interface. This helps in managing database queries and makes testing easier.

// 2. **Create a Service:**
// TODO: Create a User Service. This will handle the logic related to users. The service will use the User Repository for any database actions.

// 3. **Write Tests:**
// TODO: Write tests for the User Service to make sure everything works as it should. And feature tests for repositories methods

// 4. **Update Controller:**
// TODO: Change the Controller to use the new Service and fix any errors. Update Swagger Docs as needed.

// 5. **Handle Errors:**
// TODO: Improve how errors are handled. For example, let the user know if the country they provided doesn’t exist.

// 6. **Use Dependency Injection:**
// TODO: Use Dependency Injection for the User Service in the Controller, and link the User Repository Interface to its implementation.

class UserController extends Controller
{
    public function getUsersByCountry(Request $request): JsonResponse
    {

        $countryName = $request->query('country', 'Canada'); // Default is Canada if no country provided

        $country = Country::where('name', $countryName)->first();

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $users = User::whereHas('companies', function ($query) use ($country) {
            $query->where('country_id', $country->id);
        })
            ->with([
                'companies' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->select('id', 'name')
            ->get();

        return response()->json($users);
    }
}
