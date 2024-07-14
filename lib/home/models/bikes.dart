import 'package:equatable/equatable.dart';

final class Bikes extends Equatable {
  final String brand;
  final String model;

  const Bikes({
    required this.brand,
    required this.model,
  });

  @override
  List<Object> get props => [brand, model];
}
