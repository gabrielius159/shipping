## Excersice for Estina

- We expect this to be unit tested. No need to implement any api, they can be mocked, just return a hard coded result.
- Order can have multiple shippings, when the order is ready to be shipped we need to send the address and order id to the shipping provider.
##Requirements
- Implement a function that registerShipping, make it for every shipping provider
- UPS, send by api to upsfake.com/register -> order_id, country, street, city, post_code
- DHL, send by api to dhlfake.com/register -> order_id, country, address, town, zip_code
- OMNIVA - get by api pick up point (omnivafake.com/pickup/find ) : country, post code
          - send (omnivafake.com/register) pickup_point_id and order id