# P.A.L

##### <u>Purpose</u>

*This API is made for developers to interact with the backend*

### User

------

##### Register	

This request creates a new user under the following fields.

```
@POST => "http://example.com/api/register"
return { "status"  : boolean
		 "message" : int
}
```

|Key | Value | Type |
|------------ | -------------|------------ |
|name | required | string |
|email | required | string |
|password | required | string |
|birthday | null | date |
|school | null | string |
|school_id | null | int |
|grad_year | null | int |
|gender | null | string |
|phone_number | null | string |



##### Log-in	

This request allows a user to log-in

```
@POST => "http://example.com/api/login"
return { "status"  : boolean
		 "message" : string
}
```

|Key |Value |Type |
|------------ | -------------|------------ |
|email |required |string |
|password |required |string |



### Profile

------

##### Update

This request allows a user to update their profile page

```
@POST => "http://example.com/api/profile/update/{id}"
return { "status"  : boolean
		 "message" : string
}

*id == user_id
```


| Key          | Value | Type   |
| ------------ | ----- | ------ |
| birth_date   | null  | date   |
| school       | null  | string |
| school_id    | null  | int    |
| grad_year    | null  | int    |
| gender       | null  | string |
| phone_number | null  | string |
| counselor_id | null  | int    |
| name         | null  | string |

##### Get Profile Data

This request will return a user's profile in JSON

```
@GET => "http://example.com/api/profile/{id}"
return json(Example)

*{id} == user_id
```

**Example:**

```
{
    "id": 1,
    "name": "Mackensie",
    "email": "mackensie@gmail.com",
    "birth_date": null,
    "role" : 0,
    "school": null,
    "school_id": null,
    "grad_year": null,
    "gender": null,
    "phone_number": null,
    "counselor_id": null,
    "created_at": "2018-06-11 01:22:24",
    "updated_at": "2018-06-11 01:22:24"
}
```



##### Get Profile Data By CounselorID

This request will return students with that counselor in JSON

```
@GET => "http://example.com/api/profile/counselor/{id}"
return json(Example) with role 0

*{id} == counselor_id

@GET => "http://example.com/api/profile/counselor/{id}/*"
return json(Example) with role higher than 0

*{id} == counselor_id
```

**Example:**

```
{
    "id": 1,
    "name": "Mackensie",
    "email": "mackensie@gmail.com",
    "birth_date": null,
    "role" : 0,
    "school": null,
    "school_id": null,
    "grad_year": null,
    "gender": null,
    "phone_number": null,
    "counselor_id": null,
    "created_at": "2018-06-11 01:22:24",
    "updated_at": "2018-06-11 01:22:24"
}
```



### Forms

------

##### Register Form

This request create a new form

```
@POST => "http://example.com/api/register/form"
return { "status"  : boolean
		 "message" : int
}
```
| Key       | Value | Type   |
| --------- | ----- | ------ |
| name      | null  | string |
| form_type | null  | int    |




##### Get Form by Index

This request will return a form based on form_id

```
@GET => "http://example.com/api/get/form/index/{id}"
return json(Example)

*{id} == form_id
```

**Example:**

```
[
    {
        "id": 1,
        "form_id": 6,
        "question": "When is the FitnessGram Pacer Test",
    },
    {
        "id": 2,
        "form_id": 6,
        "question": "Is the FitnessGram Pacer Test a multistage aerobic capacity test 
        that progressively gets more difficult as it continues? The twenty meter pacer 
        test will begin in thirty seconds. Line up at the start. The running speed 
        starts slowly but gets faster each minute after you hear this signal bodeboop. A 
        sing lap should be completed every time you hear this sound. ding Remember to 
        run in a straight line and run as long as possible. The second time you fail to 
        complete a lap before the sound, your test is over. The test will begin on the 
        word start.",
    }
]
```




##### Get Form by Submission

This request will return a form based on submitted_id

```
@GET => "http://example.com/api/get/form/submit/{id}"
return json(Example)

*{id} == submitted_id
```

**Example:**

```
[
    {
        "id": 1,
        "form_id": 6,
        "question": "When is the FitnessGram Pacer Test",
        "answer": null,
        "name": "The FitnessGram Pacer Test ..."
    },
    {
        "id": 2,
        "form_id": 6,
        "question": "Is the FitnessGram Pacer Test a multistage aerobic capacity test 
        that progressively gets more difficult as it continues? The twenty meter pacer 
        test will begin in thirty seconds. Line up at the start. The running speed 
        starts slowly but gets faster each minute after you hear this signal bodeboop. A 
        sing lap should be completed every time you hear this sound. ding Remember to 
        run in a straight line and run as long as possible. The second time you fail to 
        complete a lap before the sound, your test is over. The test will begin on the 
        word start.",
        "answer": 1,
        "name": "The FitnessGram Pacer Test ..."
    }
]
```



### Questions

------

##### Register Question

This request will assign a question to a form

```
@POST => "http://example.com/api/register/question/{id}"
return { "status"  : boolean
		 "message" : int
}

*{id} == form_id
```
| Key      | Value    | Type   |
| -------- | -------- | ------ |
| question | required | string |



### Submission

------
##### Register Submission

This request will assign a user a form to submit

```
@GET => "http://example.com/api/register/submission/{user_id}/{form_id}"

return { "status"  : boolean
		 "message" : int
}

*{user_id} == user_id
*{form_id} == form_id
```



##### Get Submission Status

This will return the submission status

```
@GET => "http://example.com/api/status/{id}"

return { 
	"submission status" : int
	"message" : string
}

*{id} == submit_id
```



##### Submit Submission

Changes Submission status to 1

```
@GET => "http://example.com/api/submit/{id}"

return { 
	"submission status" : int
	"message" : string
}

*{id} == submit_id
```



##### Get Available Submissions

This will return the submission ids and form names 

```
@GET => "http://example.com/api/get/form/available/{user_id}"

return { 
	"id" : int
	"name" : string
}

*{id} == submission_id
*{name} == form_name
```





### Answers

------

##### Submit Answer 

This request will Answer a Question based question_id and submitted_id

```
@POST => "http://example.com/api/submit/question/{question_id}/{submitted_id}"

return { "status"  : boolean
		 "message" : string
}

*{question_id} == question_id
*{submitted_id} == submitted_id
```

| Key    | Value    | Type |
| ------ | -------- | ---- |
| answer | required | int  |



### Approve/Resend

------

##### Approve

​	This request allows a user with certain permissions to finalize a submission with submitted_id

```
@GET => "http://example.com/api/approve/{id}"
return { "status"  : boolean
		 "message" : string
}

*{id} == submitted_id
```



##### Resend

​	This allows a user with certain permissions to request a resubmission with submitted_id

```
@GET => "http://example.com/api/resend/{id}"
return { "status"  : boolean
		 "message" : string
}

*{id} == submitted_id
```



##### Register	

This request creates a new user under the following fields.

```
@POST => "http://example.com/api/register"
return { "status"  : boolean
		 "message" : int
}
```

| Key          | Value    | Type   |
| ------------ | -------- | ------ |
| name         | required | string |
| email        | required | string |
| password     | required | string |
| birthday     | null     | date   |
| school       | null     | string |
| school_id    | null     | int    |
| grad_year    | null     | int    |
| gender       | null     | string |
| phone_number | null     | string |





### Chat 

------

##### Chat requires a unique identifier in order to send messages between users. To request this unique identifier you must join a room. 


##### Send

​	This request let you send a message based on the sender and receiver and it will be sent to the socket-io server

```
@POST => "http://example.com/api/chat/send"
return { 
		"id": int,
        "sender": string,
        "receiver": string,
        "name": string,
        "updated_at": TIMESTAMP,
        "created_at": TIMESTAMP
}

*{id} == chat_id
*{user_id} == user_id

((negative) int == User who sent the last message)
```

| Key          | Value    | Type   |
| ------------ | -------- | ------ |
| message      | required | string |
| sender       | required | string |
| receiver     | required | string |





### Database Diagram Simplification

------

##### This Diagram will help clarify the order in which Forms, Questions and Answers will need to be registered and submitted.

![Alt](https://imgur.com/a/P4Depru)



### Chat Diagram Simplification

------

##### This Diagram will help clarify the order in which a chat will be initiated.

![Alt](https://lh3.googleusercontent.com/-05UrOjESLx--UOR_z13QOsc_8o5CQN3Jbkw1Eb0ZhFos4R6uGm16FFQisligLZYl5ITOzw0ikEYcNbdxvGb=w942-h633)



## License

[MIT](http://opensource.org/licenses/MIT)

Copyright (c) 2018-present, New Jersey City University, NJCU

