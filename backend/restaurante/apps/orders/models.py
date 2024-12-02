from django.db import models

class Order(models.Model):
    STATUS_CHOICES = [
        ('pending', 'Pending'),
        ('paid', 'Paid'),
        ('preparing', 'Preparing'),
        ('completed', 'Completed'),
        ('cancelled', 'Cancelled'),
    ]

    customer_name = models.CharField(max_length=255)
    table_number = models.IntegerField()
    items = models.ManyToManyField('menu.MenuItem', related_name='orders')
    status = models.CharField(max_length=20, choices=STATUS_CHOICES, default='pending')
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    def __str__(self):
        return f"Order {self.id} - {self.customer_name} ({self.status})"


