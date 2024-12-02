from django.db import models
from apps.orders.models import Order  # Asegúrate de que esta importación sea correcta

class Sale(models.Model):
    order = models.OneToOneField(Order, on_delete=models.CASCADE, related_name="sale")
    total = models.DecimalField(max_digits=10, decimal_places=2)
    created_at = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"Sale for Order {self.order.id} - Total: {self.total}"

