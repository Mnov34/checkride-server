import 'package:flutter/material.dart';
import 'package:checkride_mobile/home/home.dart';

class HomeListItem extends StatelessWidget {
  const HomeListItem({required this.bike, super.key});

  final Bike bike;

  @override
  Widget build(BuildContext context) {
    final textTheme = Theme.of(context).textTheme;
    return Material(

      child: ListTile(
        leading: Text(bike.brand, style: textTheme.bodySmall),
        title: Text(bike.model),
        dense: true,
      ),
    );
  }
}