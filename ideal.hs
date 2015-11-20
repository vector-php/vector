module Test where

data Request a = 
    Request a
    
data Response a = 
    Response a 
    
data User = User
    { name :: String
    } deriving (Show)

validateUser :: Request String -> Maybe User
validateUser _ =
    Just $ User "Joseph"

updateUserInfo :: Request String -> Maybe User -> Response Int
updateUserInfo _ _ =
    Response 7

get :: Request String -> Response Int
get req =
    updateUserInfo req (validateUser req)
