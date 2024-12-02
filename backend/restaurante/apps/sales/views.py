from django.shortcuts import render
from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status
from django.db.models import Sum, Count
from .models import Sale
from .serializers import SaleSerializer
from apps.menu.models import MenuItem

class SalesListView(APIView):
    def get(self, request):
        """Obtener el historial de ventas."""
        sales = Sale.objects.all()
        serializer = SaleSerializer(sales, many=True)
        return Response(serializer.data)

class SalesStatsView(APIView):
    def get(self, request):
        """Obtener estadísticas de ventas."""
        total_sales = Sale.objects.aggregate(total=Sum('total'))['total']
        total_orders = Sale.objects.count()
        most_sold_item = (
            MenuItem.objects.filter(order__items__sale__isnull=False)
            .annotate(sold_count=Count('order__items'))
            .order_by('-sold_count')
            .first()
        )

        stats = {
            "total_sales": total_sales or 0,
            "total_orders": total_orders,
            "most_sold_item": most_sold_item.name if most_sold_item else None,
        }
        return Response(stats)

